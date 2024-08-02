<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden_item extends Model
{
    use HasFactory;
    protected $fillable = [
        'orden_id', 'item_id', 'cantidad', 'precio_unitario', 'total',
    ];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
