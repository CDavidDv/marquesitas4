<?php

namespace App\Http\Controllers;

use App\Models\Bebida;
use App\Models\Marquesita;
use App\Models\Orden;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Models\BebidasInventario;
use App\Models\Ingrediente;
use App\Models\Orden_item;
use Carbon\Carbon;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user(); 
        $sucursalId = $user->sucursal_id;

        $bebidas = BebidasInventario::all();
        $ingredientes = Ingrediente::all();
        $ordens = orden::where('sucursal_id', $sucursalId)
        ->whereNotIn('estado',['Entregado', 'Cancelado'])
        ->with(['marquesitas.ingredientes', 'bebidas'])
        ->get();

        return Inertia::render('Dashboard', [
            'bebidas' => $bebidas,
            'ingredientes' => $ingredientes,
            'ordens' => $ordens
        ]);

    }

    public function datosfiltrados(Request $request)
    {
        $request->validate([
            'filter' => 'required|in:day,week,month',
            'value' => 'required|string',
        ]);

        $filter = $request->input('filter');
        $value = $request->input('value');

        $query = Orden::query();

        switch ($filter) {
            case 'day':
                $query->whereDate('created_at', $value);
                break;
            case 'week':
                [$year, $week] = explode('-W', $value);
                $startOfWeek = Carbon::now()->setISODate($year, $week)->startOfWeek();
                $endOfWeek = Carbon::now()->setISODate($year, $week)->endOfWeek();
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                break;
            case 'month':
                $date = Carbon::parse($value);
                $query->whereMonth('created_at', $date->month);
                $query->whereYear('created_at', $date->year);
                break;
            default:
                return Inertia::render('Corte', [
                    'ordens' => [],
                    'totalEfectivo' => 0,
                    'totalTarjeta' => 0,
                    'totalTransferencia' => 0,
                    'totalBruto' => 0,
                    'numeroDeOrdenes' => 0,
                    'numeroDeMarquesitas' => 0,
                    'sucursal' => auth()->user()->sucursal_id,
                    'hoy' => Carbon::now()->toDateString(),
                ]);
        }

        $ordens = $query->with('marquesitas')->get(); // Asegúrate de cargar la relación marquesitas

        $totalEfectivo = $ordens->where('metodo', 'Efectivo')->sum('total');
        $totalTarjeta = $ordens->where('metodo', 'Tarjeta')->sum('total');
        $totalTransferencia = $ordens->where('metodo', 'Transferencia')->sum('total');
        $totalBruto = $totalEfectivo + $totalTarjeta + $totalTransferencia;
        $numeroDeOrdenes = $ordens->count();
        
        // Calcular el número total de marquesitas considerando la columna cantidad
        $numeroDeMarquesitas = $ordens->sum(function ($orden) {
            return $orden->marquesitas->sum('cantidad'); // Sumar la columna 'cantidad'
        });

        return Inertia::render('Corte', [
            'ordens' => $ordens,
            'totalEfectivo' => $totalEfectivo,
            'totalTarjeta' => $totalTarjeta,
            'totalTransferencia' => $totalTransferencia,
            'totalBruto' => $totalBruto,
            'numeroDeOrdenes' => $numeroDeOrdenes,
            'numeroDeMarquesitas' => $numeroDeMarquesitas,
            'sucursal' => auth()->user()->sucursal_id,
            'hoy' => Carbon::now()->toDateString(),
            'selectedFilter' => $filter,
            'selectedDate' => $filter === 'day' ? $value : '',
            'selectedWeek' => $filter === 'week' ? $value : '',
            'selectedMonth' => $filter === 'month' ? $value : '',
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user(); // Obtiene el usuario autenticado
        $sucursalId = $user->sucursal_id;

        $pedidoData = $request->validate([
            'nombre_comprador' => 'required|string',
            'pago' => 'required|numeric',
            'cambio' => 'required|numeric',
            'estado' => 'required|string',
            'metodo' => 'required|string',
            'total' => 'required|numeric',
            'marquesitas' => 'nullable|array',
            'bebidas' => 'nullable|array',
            'categorias' => 'nullable|array',
        ]);

        // Asegúrate de que al menos uno de los arrays no esté vacío
        if (empty($pedidoData['marquesitas']) && empty($pedidoData['bebidas']) && empty($pedidoData['categorias'])) {
            return redirect()->back()->withErrors(['pedido' => 'Debe agregar al menos una marquesita, bebida o categoría al pedido.']);
        }

        // Añadir sucursal_id a los datos del pedido
        $pedidoData['sucursal_id'] = $sucursalId;
        
        // Crear la orden
        $pedido = Orden::create([
            'nombre_comprador' => $pedidoData['nombre_comprador'],
            'pago' => $pedidoData['pago'],
            'cambio' => $pedidoData['cambio'],
            'estado' => $pedidoData['estado'],
            'metodo' => $pedidoData['metodo'],
            'total' => $pedidoData['total'],
            'sucursal_id' => $sucursalId,
        ]);

        if (!empty($pedidoData['marquesitas'])) {
            foreach ($pedidoData['marquesitas'] as $marquesitaData) {
                $marquesita = new Marquesita([
                    'precio_marquesita' => $marquesitaData['precio'],
                    'cantidad' => $marquesitaData['cantidad']
                ]);

                $pedido->marquesitas()->save($marquesita);

                if (isset($marquesitaData['ingredientes'])) {
                    foreach ($marquesitaData['ingredientes'] as $ingredienteId) {
                        $marquesita->ingredientes()->attach($ingredienteId);
                    }
                }
            }
        }

        if (!empty($pedidoData['bebidas'])) {
            foreach ($pedidoData['bebidas'] as $bebidaData) {
                $bebida = new Bebida([
                    'nombre' => $bebidaData['nombre'],
                    'precio' => $bebidaData['precio'],
                    'cantidad' => $bebidaData['cantidad']
                ]);

                $pedido->bebidas()->save($bebida);
            }
        }
        
        // Guardar orden_items para categorías e items
        if (!empty($pedidoData['categorias'])) {
            foreach ($pedidoData['categorias'] as $categoria) {
                foreach ($categoria['items'] as $item) {
                    Orden_item::create([
                        'orden_id' => $pedido->id,
                        'item_id' => $item['id'],
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $item['precio'],
                        'total' => $item['cantidad'] * $item['precio'],
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', [
            'message' => 'Pedido guardado con éxito',
            'clearForm' => true,
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'estado' => 'required|string'
        ]);

        $pedido = orden::findOrFail($id);
        $pedido->estado = $validated['estado'];
        $pedido->save();

        return redirect()->back()->with('success', [
            'message' => 'Pedido editado con éxito',
            'clearForm' => true
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
