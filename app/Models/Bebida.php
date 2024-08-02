<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bebida extends Model
{
    use HasFactory;

    protected $fillable = ['orden_id', 'nombre', 'precio', 'cantidad'];
    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'bebida_id');
    }
}
