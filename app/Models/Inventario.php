<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    
    protected $fillable = ['sucursal_id', 'ingrediente_id', 'bebida_id', 'cantidad'];
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    // Define la relación con el modelo Bebida
    public function bebida()
    {
        return $this->belongsTo(Bebida::class, 'bebida_id');
    }

    // Si tienes una clave foránea 'ingrediente_id' que apunta al modelo Ingrediente
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'ingrediente_id');
    }
}
