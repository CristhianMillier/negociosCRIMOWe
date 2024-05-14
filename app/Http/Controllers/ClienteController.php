<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Documento;
use App\Models\Cliente;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Exception;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;

class ClienteController extends Controller
{

    function __construct(){
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|eliminar-cliente',['only'=>['index']]);
        $this->middleware('permission:crear-cliente',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-cliente',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-cliente',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('documento')->latest()->get();
        return view('cliente.index')->with('clientes', $clientes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipo_documentos = Documento::all();
        return view('cliente.create')->with('tipo_documentos', $tipo_documentos);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        try{
            DB::beginTransaction();
            $cliente = Cliente::create($request->validated());
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado');
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
    public function edit(Cliente $cliente)
    {
        $cliente->load('documento');
        return view('cliente.edit')->with('cliente', $cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        Cliente::where('id', $cliente->id)
        ->update($request->validated());

        return redirect()->route('clientes.index')->with('success', 'Cliente editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $cliente = Cliente::find($id);
        if ($cliente->estado == 1){
            Cliente::where('id', $cliente->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Cliente eliminado';
        } else{
            Cliente::where('id', $cliente->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Cliente restaurado';
        }

        return redirect()->route('clientes.index')->with('success', $message);
    }
}