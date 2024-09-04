<?php

namespace App\Http\Controllers;

use App\Models\Inventarios;
use Illuminate\Http\Request;

class InventariosController extends Controller
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
        ]);

        $sucursalId = $request->input('sucursal_id');

        // Elimina el inventario existente para la sucursal
        Inventarios::where('sucursal_id', $sucursalId)->delete();

        // Agrega el nuevo inventario
        foreach ($request->input('ingredientes', []) as $ingrediente) {
            Inventarios::create([
                'sucursal_id' => $sucursalId,
                'ingrediente_id' => $ingrediente['id'],
                'cantidad' => $ingrediente['cantidad']
            ]);
        }

        foreach ($request->input('bebidas', []) as $bebida) {
            Inventarios::create([
                'sucursal_id' => $sucursalId,
                'bebida_id' => $bebida['id'],
                'cantidad' => $bebida['cantidad']
            ]);
        }

        return redirect()->back()->with('success', 'Inventario actualizado con éxito');
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
}
