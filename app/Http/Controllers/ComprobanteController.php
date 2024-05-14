<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Comprobante;
use Exception;
use App\Http\Requests\StoreComprobanteRequest;
use App\Http\Requests\UpdateComprobanteRequest;

class ComprobanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comprobantes = Comprobante::all();
        return view('comprobante.index')->with('comprobantes', $comprobantes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comprobante.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComprobanteRequest $request)
    {
        try{
            DB::beginTransaction();
            $comprobante = Comprobante::create($request->validated());
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('comprobantes.index')->with('success', 'Comprobante registrado');
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
    public function edit(Comprobante $comprobante)
    {
        return view('comprobante.edit')->with('comprobante', $comprobante);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComprobanteRequest $request, Comprobante $comprobante)
    {
        Comprobante::where('id', $comprobante->id)
        ->update($request->validated());

        return redirect()->route('comprobantes.index')->with('success', 'Comprobante editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $comprobante = Comprobante::find($id);
        if ($comprobante->estado == 1){
            Comprobante::where('id', $comprobante->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Comprobante eliminado';
        } else{
            Comprobante::where('id', $comprobante->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Comprobante restaurado';
        }

        return redirect()->route('comprobantes.index')->with('success', $message);
    }
}