<?php

namespace App\Http\Controllers;

use App\Models\PrecioMarquesita;
use Illuminate\Http\Request;

class PrecioMarquesitaController extends Controller
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
    public function update(Request $request)
    {
        $validated = $request->validate([
            'precio' => 'required'
        ]);

        $pedido = PrecioMarquesita::findOrFail(1);
        $pedido->precio = $validated['precio'];
        $pedido->save();

        return redirect()->back()->with('success', [
            'precionuevo' =>  $validated['precio'],
            'message' => 'Marquesita editado con éxito',
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
