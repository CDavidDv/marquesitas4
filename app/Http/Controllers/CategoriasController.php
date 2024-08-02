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

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

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
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->back()->with('success', 'Categoría agregada con éxito',  $categorias = Categoria::with('items')->get());
    }

    public function index()
    {
        $categorias = Categoria::with('items')->get();
        return inertia('TuVista', ['categorias' => $categorias]); // Ajusta 'TuVista' al nombre de tu vista Inertia
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->back()->with('success', 'Categoría actualizada con éxito');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->back()->with('success', 'Categoría eliminada con éxito');
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
