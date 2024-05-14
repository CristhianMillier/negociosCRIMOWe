<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Marca;
use App\Models\Categoria;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Exception;
use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-producto|crear-producto|editar-producto|eliminar-producto',['only'=>['index']]);
        $this->middleware('permission:crear-producto',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-producto',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-producto',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('marca', 'categoria')->latest()->get();
        return view('producto.index')->with('productos', $productos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = Marca::all()->where('estado', 1);
        $categorias = Categoria::all()->where('estado', 1);
        $latestId = Producto::max('id') + 1;
        $formattedId = sprintf('%010d', $latestId);
        return view('producto.create',compact('marcas', 'categorias', 'formattedId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        try{
            DB::beginTransaction();
            $producto = new Producto;
            if ($request->hasFile('image_path')) {
                $imagen = $producto->handleUploadImage($request->file('image_path'));
            } else {
                $imagen = null;
            }

            $producto->fill([
                'codigo_producto' => $request->codigo_producto,
                'descripcion' => $request->descripcion,
                'procedencia' => $request->procedencia,
                'codigo_barra' => $request->codigo_barra,
                'image_path' => $imagen,
                'marca_id' => $request->marca_id,
                'categoria_id' => $request->categoria_id
            ]);
            $producto->save();
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'Producto registrado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $marcas = Marca::all()->where('estado', 1);
        $categorias = Categoria::all()->where('estado', 1);
        return view('producto.edit',compact('marcas', 'categorias', 'producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        try{
            DB::beginTransaction();
            if ($request->hasFile('image_path')) {
                $imagen = $producto->handleUploadImage($request->file('image_path'));
                if (Storage::disk('public')->exists('/productos/'.$producto->image_path)){
                    Storage::disk('public')->delete('/productos/'.$producto->image_path);
                }
            } else {
                $imagen = $producto->image_path;
            }

            $producto->fill([
                'codigo_producto' => $request->codigo_producto,
                'descripcion' => $request->descripcion,
                'procedencia' => $request->procedencia,
                'codigo_barra' => $request->codigo_barra,
                'image_path' => $imagen,
                'marca_id' => $request->marca_id,
                'categoria_id' => $request->categoria_id
            ]);
            $producto->update();
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'Producto editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $producto = Producto::find($id);
        if ($producto->estado == 1){
            Producto::where('id', $producto->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Producto eliminado';
        } else{
            Producto::where('id', $producto->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Producto restaurado';
        }

        return redirect()->route('productos.index')->with('success', $message);
    }
}