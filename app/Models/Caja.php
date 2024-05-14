<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    public function comprobante(){
        return $this->belongsTo(Comprobante::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['serie_text', 'serie_num', 'num_comprobante', 'impuesto', 'pago', 'fecha_hora', 
        'comprobante_id', 'venta_id', 'user_id'];
}