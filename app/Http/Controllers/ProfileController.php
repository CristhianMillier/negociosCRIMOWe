<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Exception;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('profile.index')->with('user', $user);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $profile)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$profile->id,
            'password' => 'nullable|min:8|same:password_confirmar',
        ]);

        try{
            DB::beginTransaction();

            if (empty($request->password)){
                $request = Arr::except($request,array('password'));
            } else{
                $hashFile = Hash::make($request->password);
                $request->merge(['password' => $hashFile]);
            }

            $profile->update($request->all());
            
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('profile.index')->with('success', 'Perfil actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}