<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventariosOtro extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'sucursal_id', 'cantidad'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
