<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Almacene;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|eliminar-usuario',['only'=>['index']]);
        $this->middleware('permission:crear-usuario',['only'=>['create', 'store']]);
        $this->middleware('permission:editar-usuario',['only'=>['edit', 'update']]);
        $this->middleware('permission:eliminar-usuario',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('user.index')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $almacenes = Almacene::all();
        return view('user.create', compact('roles', 'almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();

            $hashFile = Hash::make($request->password);
            $request->merge(['password' => $hashFile]);

            $user = User::create($request->all());

            $user->assignRole($request->role);
            
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('users.index')->with('success', 'Usuario registrado');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        $almacenes = Almacene::all();
        return view('user.edit', compact('roles', 'almacenes', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try{
            DB::beginTransaction();

            if (empty($request->password)){
                $request = Arr::except($request,array('password'));
            } else{
                $hashFile = Hash::make($request->password);
                $request->merge(['password' => $hashFile]);
            }

            $user->update($request->all());

            $user->syncRoles([$request->role]);
            
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('users.index')->with('success', 'Usuario editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $rolUser = $user->getRoleNames()->first();
        $user->removeRole($rolUser);
        $user->delete();
        

        return redirect()->route('users.index')->with('success', 'Usuario eliminado');
    }
}