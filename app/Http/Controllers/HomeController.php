<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Proveedore;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Compra;
use App\Models\Venta;

class HomeController extends Controller
{
    public function index(){
        if (Auth::check()){
            $usuario = User::find(Auth::user()->id);
            $roles = $usuario->getRoleNames();
            $rol = $roles[0];
            
            $users = count(User::all());
            $clientes = count(Cliente::all());
            $proveedores = count(Proveedore::all());
            $productos = count(Producto::all());
            $marcas = count(Marca::all());
            $categorias = count(Categoria::all());
            $compras = count(Compra::all());
            $ventas = count(Venta::all());

            return view('dashboard.index',compact('rol', 'users', 'clientes', 'proveedores', 'productos', 'marcas', 
                'categorias', 'compras', 'ventas'));
        } else{
            return redirect()->route('login');
        }
    }
}