<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos_almacenado extends Model
{
    use HasFactory;

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function almacene(){
        return $this->belongsTo(Almacene::class);
    }

    protected $fillable = ['stock', 'precio', 'producto_id', 'almacene_id'];
}