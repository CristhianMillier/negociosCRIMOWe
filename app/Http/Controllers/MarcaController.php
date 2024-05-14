<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Marca;
use Exception;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class MarcaController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-marca|crear-marca|editar-marca|eliminar-marca',['only'=>['index']]);
        $this->middleware('permission:crear-marca',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-marca',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-marca',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::all();
        return view('marca.index')->with('marcas', $marcas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request)
    {
        try{
            DB::beginTransaction();
            $marca = Marca::create($request->validated());
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('marcas.index')->with('success', 'Marca registrada');
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
    public function edit(Marca $marca)
    {
        return view('marca.edit')->with('marca', $marca);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        Marca::where('id', $marca->id)
        ->update($request->validated());

        return redirect()->route('marcas.index')->with('success', 'Marca editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $marca = Marca::find($id);
        if ($marca->estado == 1){
            Marca::where('id', $marca->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Marca eliminada';
        } else{
            Marca::where('id', $marca->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Marca restaurada';
        }

        return redirect()->route('marcas.index')->with('success', $message);
    }
}