<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    public function compras(){
        return $this->hasMany(Compra::class);
    }

    public function cajas(){
        return $this->hasMany(Caja::class);
    }

    protected $fillable = ['nombre', 'serie_text', 'estado'];
}