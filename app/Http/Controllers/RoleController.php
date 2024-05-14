<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Exception;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct(){
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|eliminar-rol',['only'=>['index']]);
        $this->middleware('permission:crear-rol',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-rol',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-rol',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('role.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array|min:1',
        ]);

        try{
            DB::beginTransaction();
            
            $rol = Role::create(['name' => $request->name]);
            
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $rol->syncPermissions($permissions);
            
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('roles.index')->with('success', 'Rol registrado');
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
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('role.edit', compact('role', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
            'permission' => 'required|array|min:1',
        ]);

        try{
            DB::beginTransaction();
            
            Role::where('id', $role->id)
            ->update([
                'name' => $request->name
            ]);;
            
            $permissions = Permission::whereIn('id', $request->permission)->get();
            $role->syncPermissions($permissions);
            
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('roles.index')->with('success', 'Rol editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado');
    }
}