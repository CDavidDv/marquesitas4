<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catego extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];
    protected $table = 'categos';
    public function items()
    {
        return $this->hasMany(Itemsinventarios::class);
    }
}
