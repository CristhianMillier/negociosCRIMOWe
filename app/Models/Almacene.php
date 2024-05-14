<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacene extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }

    public function productos_almacenados(){
        return $this->hasMany(Productos_almacenado::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps()
        ->withPivot('cantidad', 'fecha_hora', 'estado', 'user_id');
    }

    protected $fillable = ['direccion', 'distrito', 'provincia', 'departamento', 'serie_comprobante'];
}