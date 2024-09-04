<?php

namespace App\Http\Controllers;

use App\Models\Catego;
use Illuminate\Http\Request;

class CategoController extends Controller
{
  
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Catego::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->back()->with('success', 'Categoría agregada con éxito',  $categorias = Catego::with('items')->get());
    }

    public function index()
    {
        $categorias = Catego::with('items')->get();
        return inertia('TuVista', ['categorias' => $categorias]); // Ajusta 'TuVista' al nombre de tu vista Inertia
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Catego::findOrFail($id);
        $categoria->update([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->back()->with('success', 'Categoría actualizada con éxito');
    }

    public function destroy($id)
    {
        $categoria = Catego::findOrFail($id);
        $categoria->delete();

        return redirect()->back()->with('success', 'Categoría eliminada con éxito');
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

   
}
