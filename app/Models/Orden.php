<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;
    

    public function items()
    {
        return $this->belongsToMany(Item::class, 'orden_item')
                    ->withPivot('cantidad', 'precio_unitario', 'total')
                    ->withTimestamps();
    }
    public function marquesitas()
    {
        return $this->hasMany(Marquesita::class);
    }

    public function bebidas()
    {
        return $this->hasMany(Bebida::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    protected $fillable = [
        'nombre_comprador', 'pago', 'cambio', 'estado', 'metodo', 'total', 'sucursal_id',
    ];

    public function ordenItems()
    {
        return $this->hasMany(Orden_item::class);
    }
}
