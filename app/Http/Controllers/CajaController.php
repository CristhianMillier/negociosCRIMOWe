<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Almacene;
use App\Models\Caja;
use App\Models\Comprobante;
use App\Models\Productos_almacenado;
use Exception;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-caja|cobranza',['only'=>['index']]);
        $this->middleware('permission:cobranza',['only'=>['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = DB::table('ventas')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->join('almacenes', 'users.almacene_id', '=', 'almacenes.id')
        ->where('ventas.estado', 1)
        ->where('almacenes.id', auth()->user()->almacene_id)
        ->select('clientes.razon_social', 'ventas.*')
        ->get();

        return view('caja.index')->with('ventas', $ventas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        $venta = Venta::find($id);
        $comprobantes = Comprobante::all();;
        return view('caja.edit',compact('venta', 'comprobantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $caja)
    {
        $request->validate([
            'pago' => 'required',
            'fecha_hora' => 'required',
            'user_id' => 'required|exists:users,id',
            'comprobante_id' => 'required|exists:comprobantes,id',
        ]);
        
        try{
            DB::beginTransaction();
            
            $comprobate = Comprobante::find($request->comprobante_id);
            $almacen = Almacene::find(auth()->user()->almacene_id);
            
            $num_comp = DB::table('cajas')->where('serie_text', $comprobate->serie_text)
            ->where('serie_num', $almacen->serie_comprobante)->value('num_comprobante');
            if ($num_comp === null) {
                $num_comp_entero = 1;
            } else{
                $num_comp_entero = intval($num_comp) + 1;
            }
            $num_comprobante = sprintf('%09d', $num_comp_entero);
            
            $venta = Venta::find($caja->id);
            $newStock = 0;
            foreach ($venta->productos as $item) {
                $newStock = $item->stock - $item->pivot->cantidad;
                DB::table('productos')->where('id', $item->id)
                ->update([
                    'stock' => $newStock
                ]);

                Productos_almacenado::where('producto_id', $item->id)
                ->where('almacene_id', 1)
                ->update([
                    'stock' => $newStock
                ]);
            }

            Caja::create([
                'serie_text' => $comprobate->serie_text,
                'serie_num' => $almacen->serie_comprobante,
                'num_comprobante' => $num_comprobante,
                'impuesto' => $venta->impuesto,
                'pago' => $request->pago,
                'fecha_hora' => $request->fecha_hora,
                'comprobante_id' => $request->comprobante_id,
                'venta_id' => $venta->id,
                'user_id' => $request->user_id
            ]);

            DB::table('ventas')->where('id', $venta->id)
                ->update([
                    'estado' => 0 //Venta Pagada
                ]);

            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('cajas.index')->with('success', 'Se registro correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}