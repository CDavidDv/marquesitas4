<?php

namespace App\Http\Controllers;

use App\Models\Bebida;
use App\Models\BebidasInventario;
use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Inventario;
use App\Models\InventariosOtro;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function agregarIngrediente(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $ingrediente = Ingrediente::create([
            'nombre' => $validated['nombre'],
            'precio' => $validated['precio'], 
            'cantidad' => 0, 
        ]);

        return redirect()->back()->with('success', 'Ingrediente agregado con éxito');
    }

    public function editarIngrediente(Request $request, $id)
    {
        $user = auth()->user();
        $ingrediente = Ingrediente::findOrFail($id);

        if ($user->sucursal_id == 0) {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'cantidad' => 'required|integer|min:0',
            ]);
            $ingrediente->update($validated);
        } else {
            $validated = $request->validate([
                'cantidad' => 'required|integer|min:0',
            ]);
            $ingrediente->update(['cantidad' => $validated['cantidad']]);
        }

        return redirect()->back()->with('success', 'Ingrediente actualizado con éxito');
    }

    public function editarBebida(Request $request, $id)
    {
        $user = auth()->user();
        $bebida = BebidasInventario::findOrFail($id);

        if ($user->sucursal_id == 0) {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'precio' => 'required|numeric|min:0',
                'cantidad' => 'required|integer|min:0',
            ]);
            $bebida->update($validated);
        } else {
            $validated = $request->validate([
                'cantidad' => 'required|integer|min:0',
            ]);
            $bebida->update(['cantidad' => $validated['cantidad']]);
        }

        return redirect()->back()->with('success', 'Bebida actualizada con éxito');
    }

    public function eliminarIngrediente($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->delete();

        return redirect()->back()->with('success', [
            'message' => 'Ingrediente eliminado con éxito',
            'clearForm' => true
        ]);
    }

    public function agregarBebida(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $bebida = BebidasInventario::create([
            'nombre' => $validated['nombre'],
            'precio' => $validated['precio'],
            'cantidad' => 0, // Asume cantidad inicial de 0
        ]);

        return redirect()->back()->with('success', 'Bebida agregado con éxito', $bebida);
    }

    

    public function eliminarBebida($id)
    {
        $bebida = BebidasInventario::findOrFail($id);
        $bebida->delete();

        return redirect()->back()->with('success', 'Bebida eliminado con éxito');
    }

    public function ingrediBebidas(Request $request)
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

        return Inertia::render('IngrediBebidas', [
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
}
