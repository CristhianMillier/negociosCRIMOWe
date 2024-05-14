<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    public function marca(){
        return $this->belongsTo(Marca::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function compras(){
        return $this->belongsToMany(Compra::class)->withTimestamps()
        ->withPivot('cantidad', 'precio_compra', 'precio_venta');
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class)->withTimestamps()
        ->withPivot('cantidad', 'precio_venta', 'descuento');
    }

    public function almacenes(){
        return $this->belongsToMany(Almacene::class)->withTimestamps()
        ->withPivot('cantidad', 'fecha_hora', 'estado', 'user_id');
    }

    public function productos_almacenes(){
        return $this->hasMany(Productos_almacenado::class);
    }
    
    protected $fillable = ['codigo_producto', 'descripcion', 'procedencia', 'precio', 'stock', 
        'codigo_barra', 'image_path', 'marca_id', 'categoria_id'];

    public function handleUploadImage($image){
        $file = $image;
        $name = time() . $file->getClientOriginalName();
        Storage::putFileAs('/public/productos', $file, $name, 'public');

        return $name;
    }
}