<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\User;
use App\Models\Cliente;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Exception;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Productos_almacenado;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;

class VentaController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta',['only'=>['index']]);
        $this->middleware('permission:crear-venta',['only'=>['create', 'store']]);
        $this->middleware('permission:mostrar-venta',['only'=>['show']]);
        $this->middleware('permission:eliminar-venta',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*$ventas = Venta::with('cliente')
        ->where('estado', 1)->where('user_id', auth()->user()->id)->latest()->get();*/

        $ventas = DB::table('ventas')
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->where('ventas.estado', 1)
        ->where('users.almacene_id', auth()->user()->almacene_id)
        ->select('clientes.razon_social', 'ventas.*')
        ->get();
        
        return view('venta.index')->with('ventas', $ventas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all()->where('estado', 1);
        $productos = DB::table('productos_almacenados')
        ->join('productos', 'productos_almacenados.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->where('productos_almacenados.stock', '>', 0)
        ->where('productos_almacenados.almacene_id', auth()->user()->almacene_id)
        ->select('productos.descripcion', 'productos.codigo_producto', 'productos.procedencia', 'marcas.nombre',
        'productos_almacenados.*')
        ->get();

        return view('venta.create',compact('clientes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try{
            DB::beginTransaction();
            $ventas = Venta::create($request->validated());
            
            $arrayProductos_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayVenta = $request->get('arrayventa');
            $arrayDescuento = $request->get('arraydescuento');

            $sizeArray = count($arrayProductos_id);
            $count = 0;
            while($count  < $sizeArray){
                $ventas->productos()->syncWithoutDetaching([
                    $arrayProductos_id[$count] => [
                        'cantidad' => $arrayCantidad[$count],
                        'precio_venta' => $arrayVenta[$count],
                        'descuento' => $arrayDescuento[$count]
                    ]
                ]);

                $count++;
            }

            DB::commit();
        } catch(Exception $e){
            dd($e);
            DB::rollBack();
        }

        return redirect()->route('ventas.index')->with('success', 'Venta registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venta = Venta::find($id);
        return view('venta.show',compact('venta'));
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
        $venta = Venta::find($id);
        $venta->productos()->detach();
        Venta::where('id', $id)
        ->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada');
    }
}