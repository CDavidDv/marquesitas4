<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'sucursales';
    protected $fillable = ['nombre', 'direccion'];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }
    public function inventariosOtros()
    {
        return $this->hasMany(InventariosOtro::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
