<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Exception;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|eliminar-categoria',['only'=>['index']]);
        $this->middleware('permission:crear-categoria',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-categoria',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria',['only'=>['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categoria.index')->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        try{
            DB::beginTransaction();
            $categoria = Categoria::create($request->validated());
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria registrada');
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
    public function edit(Categoria $categoria)
    {
        return view('categoria.edit')->with('categoria', $categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        Categoria::where('id', $categoria->id)
        ->update($request->validated());

        return redirect()->route('categorias.index')->with('success', 'Categoria editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if ($categoria->estado == 1){
            Categoria::where('id', $categoria->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Categoria eliminada';
        } else{
            Categoria::where('id', $categoria->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Categoria restaurada';
        }

        return redirect()->route('categorias.index')->with('success', $message);
    }
}