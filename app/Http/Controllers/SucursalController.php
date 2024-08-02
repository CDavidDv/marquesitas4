<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */

    

    public function sucursales()
    {
        $sucursales = Sucursal::with('user')->get();
        return Inertia::render('Sucursales', [
            'sucursales' => $sucursales
        ]);
    }
    
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado con éxito');
    }

    public function index()
    {
        $sucursales = Sucursal::with('user')->get();
        return Inertia::render('Sucursales/Index', [
            'sucursales' => $sucursales
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $sucursal = Sucursal::create([
            'nombre' => $validated['nombre'],
            'direccion' => $validated['direccion'],
        ]);

        $user = User::create([
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'sucursal_id' => $sucursal->id,
        ]);

        return redirect()->back()->with('success', 'Sucursal y usuario creados con éxito');
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'usuario' => 'sometimes|string|max:255',
            'password' => 'sometimes|string',
        ]);

        $sucursal->update([
            'nombre' => $validated['nombre'],
            'direccion' => $validated['direccion'],
        ]);

        if (!empty($validated['usuario'])) {
            $user = $sucursal->user;
            $user->update([
                'name' => $validated['usuario'],
                'password' => !empty($validated['password']) ? Hash::make($validated['password']) : $user->password,
            ]);
        }

        return redirect()->back()->with('success', 'Sucursal y usuario actualizados con éxito');
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->user->delete();
        $sucursal->delete();
        return redirect()->back()->with('success', 'Sucursal y usuario eliminados con éxito');
    }
    /**
     * Store a newly created resource in storage.
     */

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

    /**
     * Remove the specified resource from storage.
     */
}
