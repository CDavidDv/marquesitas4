<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecioMarquesita extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'precio_marquesitas';
    protected $fillable = ['precio'];
}
