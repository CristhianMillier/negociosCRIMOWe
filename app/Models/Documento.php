<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    public function proveedores(){
        return $this->hasMany(Proveedore::class);
    }

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }

    protected $fillable = ['nombre'];
}