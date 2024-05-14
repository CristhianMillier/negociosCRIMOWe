<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    public function documento(){
        return $this->belongsTo(Documento::class);
    }

    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    protected $fillable = ['razon_social', 'direccion', 'tipo_persona', 'num_documento', 'telefono', 
        'estado', 'documento_id'];
}