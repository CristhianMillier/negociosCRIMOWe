<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Documento;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use App\Models\Proveedore;
use Exception;
use App\Http\Requests\StoreProveedoreRequest;
use App\Http\Requests\UpdateProveedoreRequest;

class ProveedoreController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-proveedor|crear-proveedor|editar-proveedor|eliminar-proveedor',['only'=>['index']]);
        $this->middleware('permission:crear-proveedor',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-proveedor',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-proveedor',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('documento')->latest()->get();
        return view('proveedore.index')->with('proveedores', $proveedores);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipo_documentos = Documento::all();
        return view('proveedore.create')->with('tipo_documentos', $tipo_documentos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProveedoreRequest $request)
    {
        try{
            DB::beginTransaction();
            $proveedore = Proveedore::create($request->validated());
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado');
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
    public function edit(Proveedore $proveedore)
    {
        $proveedore->load('documento');
        return view('proveedore.edit')->with('proveedore', $proveedore);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedoreRequest $request, Proveedore $proveedore)
    {
        Proveedore::where('id', $proveedore->id)
        ->update($request->validated());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $proveedore = Proveedore::find($id);
        if ($proveedore->estado == 1){
            Proveedore::where('id', $proveedore->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Proveedor eliminado';
        } else{
            Proveedore::where('id', $proveedore->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Proveedor restaurado';
        }

        return redirect()->route('proveedores.index')->with('success', $message);
    }
}