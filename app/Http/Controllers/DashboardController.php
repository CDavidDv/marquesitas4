<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Models\Bebida;
use App\Models\BebidasInventario;
use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Inventario;
use App\Models\InventariosOtro;
use App\Models\Item;
use App\Models\Orden;
use App\Models\Sucursal;
use Carbon\Carbon;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = $request->user(); 
        $sucursalId = $user->sucursal_id;

        $bebidas = BebidasInventario::all();
        $ingredientes = Ingrediente::all();
        $categorias = Categoria::with('items')->get();
        $itemsporcat = Item::all();
        
        $ordens = Orden::where('sucursal_id', $sucursalId)
            ->whereNotIn('estado',['Entregado', 'Cancelado'])
            ->with(['marquesitas.ingredientes', 'bebidas', 'ordenItems'])
            ->get();

        $ventasPorSucursal = Orden::select('sucursal_id', DB::raw('SUM(total) as total_ventas'))
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('sucursal_id')
            ->orderBy('total_ventas', 'desc')
            ->get();

        $sucursalConMasVentas = $ventasPorSucursal->first();

        // Obtener inventario
        $ingredientesInventario = Inventario::whereNotNull('ingrediente_id')
            ->with('ingrediente')
            ->get();

        $bebidasInventario = Inventario::whereNotNull('bebida_id')
            ->with('bebida')
            ->get();

        // Obtener órdenes recientes
        $ordersInventario = Orden::orderBy('created_at', 'desc')
            ->limit(5)
            ->with('ordenItems')  // Incluir los items en las órdenes recientes también
            ->get();

        // Estadísticas de ventas
        $ventasHoy = Orden::whereDate('created_at', Carbon::today())
            ->sum('total');

        $ventasMes = Orden::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        $numeroVentasMes = Orden::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $mesAnterior = Carbon::now()->subMonth();
        $ventasMesAnterior = Orden::whereYear('created_at', $mesAnterior->year)
            ->whereMonth('created_at', $mesAnterior->month)
            ->sum('total');

        $numeroVentasMesAnterior = Orden::whereYear('created_at', $mesAnterior->year)
            ->whereMonth('created_at', $mesAnterior->month)
            ->count();

        // Calcular la diferencia porcentual
        if ($ventasMesAnterior == 0) {
            $diferenciaPorcentual = $ventasMes == 0 ? 0 : 100; // Si no hay ventas en el mes anterior y actual, 0%, si solo en actual, 100%
        } else {
            $diferenciaPorcentual = (($ventasMes - $ventasMesAnterior) / $ventasMesAnterior) * 100;
        }

        // Calcular ventas por mes para salesData
        $salesData = Orden::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as sales'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::create()->month($item->month)->format('F'), // Convertir número de mes a nombre de mes
                    'sales' => $item->sales
                ];
            });

        return Inertia::render('Dashboard', [
            'bebidas' => $bebidas,
            'ingredientes' => $ingredientes,
            'ordens' => $ordens,
            'sucursal' => $sucursalId,
            'categorias' => $categorias,
            'itemsporcat' => $itemsporcat,
            'tableroAdmin' => [
                'ingredientes' => $ingredientesInventario,
                'bebidas' => $bebidasInventario,
                'ordens' => $ordersInventario,
                'ventasHoy' => $ventasHoy,
                'ventasMes' => $ventasMes,
                'ventasMesAnterior' => $ventasMesAnterior,
                'diferenciaPorcentual' => $diferenciaPorcentual,
                'numeroVentasMesAnterior' => $numeroVentasMesAnterior,
                'numeroVentasMes' => $numeroVentasMes,
                'sucursalConMasVentas' => $sucursalConMasVentas,
                'salesData' => $salesData // Agregar salesData aquí
            ]
        ]);              
    }

   
    public function corte(Request $request)
    {
        $user = $request->user();
        $sucursalId = $user->sucursal_id;

        // Obtener la fecha de hoy
        $hoy = Carbon::now()->startOfDay();

        // Inicializar la consulta de órdenes
        $query = Orden::whereNotIn('estado', ['Cancelado', 'Pagado'])
                    ->whereDate('created_at', $hoy)
                    ->with('marquesitas.ingredientes', 'bebidas');

        // Si el usuario no es administrador, filtrar por sucursal
        if ($sucursalId > 0) {
            $query->where('sucursal_id', $sucursalId);
        }

        $ordens = $query->get();

        // Calcular totales por método de pago
        $totalEfectivo = $ordens->where('metodo', 'Efectivo')->sum('total');
        $totalTarjeta = $ordens->where('metodo', 'Tarjeta')->sum('total');
        $totalTransferencia = $ordens->where('metodo', 'Transferencia')->sum('total');

        // Calcular total bruto
        $totalBruto = $totalEfectivo + $totalTarjeta + $totalTransferencia;
        $numeroDeOrdenes = $ordens->count();
        
        // Calcular el número de marquesitas
        $numeroDeMarquesitas = $ordens->sum(function ($orden) {
            return $orden->marquesitas->sum('cantidad'); // Sumar la columna 'cantidad'
        });

        $bebidasCantidad = [];
        foreach ($ordens as $orden) {
            foreach ($orden->bebidas as $bebida) {
                if (isset($bebidasCantidad[$bebida->nombre])) {
                    $bebidasCantidad[$bebida->nombre] += $bebida->cantidad;
                } else {
                    $bebidasCantidad[$bebida->nombre] = $bebida->cantidad;
                }
            }
        }

        return Inertia::render('Corte', [
            'ordens' => $ordens,
            'totalEfectivo' => $totalEfectivo,
            'totalTarjeta' => $totalTarjeta,
            'totalTransferencia' => $totalTransferencia,
            'totalBruto' => $totalBruto,
            'numeroDeOrdenes' => $numeroDeOrdenes,
            'numeroDeMarquesitas' => $numeroDeMarquesitas,
            'bebidasCantidad' => $bebidasCantidad,
            'hoy' => $hoy,
            'sucursal' => $sucursalId
        ]);
    }




    public function inventario(Request $request)
    {
        $user = auth()->user();
        $sucursalId = $user->sucursal_id;

        $ingredientes = Ingrediente::all();
        $bebidas = BebidasInventario::all();
        $categorias = Categoria::with('items')->get();
        $items = Item::all();
        $itemsporcat = $items->groupBy('categoria_id');

        $inventariosOtros = InventariosOtro::where('sucursal_id', $sucursalId)->get();
        $inventario = Inventario::where('sucursal_id', $sucursalId)->get();

        // Mapear los datos de inventario para cada ingrediente
        $ingredientesInventario = $ingredientes->map(function($ingrediente) use ($inventario) {
            $inventarioIngrediente = $inventario->where('ingrediente_id', $ingrediente->id)->first();
            $cantidad = $inventarioIngrediente->cantidad ?? 0;
            $precioInventario = $inventarioIngrediente->precio ?? 0;
            return [
                'id' => $ingrediente->id,
                'nombre' => $ingrediente->nombre,
                'cantidad' => $cantidad,
                'precio' => $precioInventario,
                'precio_original' => $ingrediente->precio // Precio original del ingrediente
            ];
        });

        // Mapear los datos de inventario para cada bebida
        $bebidasInventario = $bebidas->map(function($bebida) use ($inventario) {
            $inventarioBebida = $inventario->where('bebida_id', $bebida->id)->first();
            $cantidad = $inventarioBebida->cantidad ?? 0;
            $precioInventario = $inventarioBebida->precio ?? 0;
            return [
                'id' => $bebida->id,
                'nombre' => $bebida->nombre,
                'cantidad' => $cantidad,
                'precio' => $precioInventario,
                'precio_original' => $bebida->precio // Precio original de la bebida
            ];
        });


        // Mapear los datos de inventario para cada item en inventariosOtros
        $otrosInventario = $items->map(function($item) use ($inventariosOtros) {
            $inventarioItem = $inventariosOtros->where('item_id', $item->id)->first();
            $cantidad = $inventarioItem->cantidad ?? 0;
            return [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'categoria_id' => $item->categoria_id,
                'cantidad' => $cantidad,
            ];
        });

        return Inertia::render('Inventario', [
            'ingredientesInventario' => $ingredientesInventario,
            'bebidasInventario' => $bebidasInventario,
            'otrosInventario' => $otrosInventario,
            'sucursal' => $sucursalId,
            'ingredientes' => $ingredientes,
            'bebidas' => $bebidas,
            'categorias' => $categorias,
            'itemsporcat' => $itemsporcat
        ]);
    }

    
    


    public function obtenerDatosDashboard()
    {
        // Obtener inventario
        $ingredientes = Inventario::whereNotNull('ingrediente_id')
            ->with('ingrediente')
            ->get();
    
        $bebidas = Inventario::whereNotNull('bebida_id')
            ->with('bebida')
            ->get();
    
        // Obtener órdenes recientes
        $ordens = Orden::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $ventasPorSucursal = Orden::select('sucursal_id', DB::raw('SUM(total) as total_ventas'))
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('sucursal_id')
            ->orderBy('total_ventas', 'desc')
            ->get();

        $sucursalConMasVentas = $ventasPorSucursal->first();
    
        // Estadísticas de ventas
        $ventasHoy = Orden::whereDate('created_at', Carbon::today())
            ->sum('total');
    
        $ventasMes = Orden::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        $numeroVentasMes = Orden::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
    
        $mesAnterior = Carbon::now()->subMonth();
        $ventasMesAnterior = Orden::whereYear('created_at', $mesAnterior->year)
            ->whereMonth('created_at', $mesAnterior->month)
            ->sum('total');

        $numeroVentasMesAnterior = Orden::whereYear('created_at', $mesAnterior->year)
            ->whereMonth('created_at', $mesAnterior->month)
            ->count();
    
        // Calcular la diferencia porcentual
        if ($ventasMesAnterior == 0) {
            $diferenciaPorcentual = $ventasMes == 0 ? 0 : 100; // Si no hay ventas en el mes anterior y actual, 0%, si solo en actual, 100%
        } else {
            $diferenciaPorcentual = (($ventasMes - $ventasMesAnterior) / $ventasMesAnterior) * 100;
        }
    
        return Inertia::render('Dashboard', [
            'ingredientes' => $ingredientes,
            'bebidas' => $bebidas,
            'ordens' => $ordens,
            'ventasHoy' => $ventasHoy,
            'ventasMes' => $ventasMes,
            'ventasMesAnterior' => $ventasMesAnterior,
            'diferenciaPorcentual' => $diferenciaPorcentual,
            'numeroVentasMesAnterior' => $numeroVentasMesAnterior,
            'numeroVentasMes' => $numeroVentasMes,
            'sucursalConMasVentas' => $sucursalConMasVentas
        ]);
    }   




}
