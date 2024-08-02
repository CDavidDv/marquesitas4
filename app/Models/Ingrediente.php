<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'precio', 'cantidad', 'detalles', 'unidad_medida'];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'ingrediente_id');
    }

}
