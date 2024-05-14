<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Compra;
use App\Models\Productos_almacenado;
use App\Models\Almacene;
use App\Models\User;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Exception;
use App\Models\Proveedore;
use App\Models\Comprobante;
use Carbon\Carbon;
use App\Models\Producto;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Requests\UpdateCompraRequest;

class CompraController extends Controller
{

    function __construct(){
        $this->middleware('permission:ver-compra|crear-compra|mostrar-compra|eliminar-compra',['only'=>['index']]);
        $this->middleware('permission:crear-compra',['only'=>['create', 'store']]);
        $this->middleware('permission:mostrar-compra',['only'=>['show']]);
        $this->middleware('permission:eliminar-compra',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('comprobante', 'proveedore')
        ->where('estado', 1)->latest()->get();
        return view('compra.index')->with('compras', $compras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedore::all()->where('estado', 1);
        $comprobantes = Comprobante::all()->where('estado', 1);
        $productos = Producto::all()->where('estado', 1);
        return view('compra.create',compact('proveedores', 'comprobantes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        try{
            DB::beginTransaction();
            $compra = Compra::create($request->validated());
            $almacen = Almacene::find(1);
            $fechaHora = Carbon::now()->toDateTimeString();
            
            $arrayProductos_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayCompra = $request->get('arraycompra');
            $arrayVentad = $request->get('arrayventa');
            $arrayProductos_idalmacen = $request->get('arrayidproducto');

            $sizeArray = count($arrayProductos_id);
            $count = 0;
            while($count  < $sizeArray){
                $compra->productos()->syncWithoutDetaching([
                    $arrayProductos_id[$count] => [
                        'cantidad' => $arrayCantidad[$count],
                        'precio_compra' => $arrayCompra[$count],
                        'precio_venta' => $arrayVentad[$count]
                    ]
                ]);

                $prodducto = Producto::find($arrayProductos_id[$count]);
                $stockActual = $prodducto->stock;
                $stockNuevo = intval($arrayCantidad[$count]);

                DB::table('productos')->where('id', $prodducto->id)
                ->update([
                    'stock' => $stockActual + $stockNuevo,
                    'precio' => $arrayVentad[$count]
                ]);


                $almacen->productos()->syncWithoutDetaching([
                    $arrayProductos_idalmacen[$count] => [
                        'cantidad' => $arrayCantidad[$count],
                        'fecha_hora' => $fechaHora,
                        'estado' => 1, //El producto a sido recibido en almacen
                        'user_id' => $request->get('user_id')
                    ]
                ]);
                $product_almacen = Productos_almacenado::where('producto_id', $arrayProductos_idalmacen[$count])->first();
                
                if ($product_almacen) {
                    Productos_almacenado::where('id', $product_almacen->id)
                    ->update([
                        'stock' => $stockActual + $stockNuevo,
                        'precio' => $arrayVentad[$count],
                        'producto_id' => $arrayProductos_idalmacen[$count],
                        'almacene_id' => 1
                    ]);
                } else {
                    Productos_almacenado::create([
                        'stock' => $stockActual + $stockNuevo,
                        'precio' => $arrayVentad[$count],
                        'producto_id' => $arrayProductos_idalmacen[$count],
                        'almacene_id' => 1
                    ]);
                }

                $count++;
            }

            DB::commit();
        } catch(Exception $e){
            dd($e);
            DB::rollBack();
        }

        return redirect()->route('compras.index')->with('success', 'Compra registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        return view('compra.show',compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $compra = Compra::find($id);
        $productosDeLaCompra = $compra->productos;
        
        foreach ($productosDeLaCompra as $item) {
            DB::table('productos')->where('id', $item->id)
            ->update([
                'stock' => $item->stock - $item->pivot->cantidad
            ]);
        }

        $almacen = Almacene::find(1);
        $productosDeAlmacen = $almacen->productos;
        foreach ($productosDeAlmacen as $itemAl) {
            Productos_almacenado::where('producto_id', $itemAl->id)
            ->update([
                'stock' => $itemAl->stock
            ]);
        }
        
        $compra->productos()->detach();
        Compra::where('id', $id)
        ->delete();

        $almacen->productos()->detach();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada');
    }
}