<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
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
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);

        $item = Item::create([
            'categoria_id' => $validated['categoria_id'],
            'nombre' => $validated['nombre'],
            'precio' => $validated['precio'],
        ]);

        return redirect()->back()->with('success', 'Categoria agregada con éxito');
    }
    
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'nullable|numeric|min:0',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'nombre' => $request->input('nombre'),
            'precio' => $request->input('precio'),
            'cantidad' => $request->input('cantidad', 0),
        ]);

        return redirect()->back()->with('success', 'Categoria agregada con éxito');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Categoria agregada con éxito');
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
    
     
}
