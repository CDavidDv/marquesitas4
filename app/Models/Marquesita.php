<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marquesita extends Model
{
    use HasFactory;

    protected $fillable = ['orden_id', 'precio_marquesita', 'cantidad'];

    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'marquesita_ingrediente');
    }

}

