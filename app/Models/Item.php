<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'categoria_id', 'precio'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function inventariosOtros()
    {
        return $this->hasMany(InventariosOtro::class);
    }
    public function ordenes()
    {
        return $this->belongsToMany(Orden::class, 'orden_item')
                    ->withPivot('cantidad', 'precio_unitario', 'total')
                    ->withTimestamps();
    }
}
