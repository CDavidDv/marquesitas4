<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarios extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'sucursal_id', 'cantidad'];
    protected $table = 'inventariosi';
    public function item()
    {
        return $this->belongsTo(Itemsinventarios::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
