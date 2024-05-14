<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $userId = $user->id;
        return [
            'name' => 'required|max:191|unique:users,name,'.$userId,
            'email' => 'required|email|unique:users,email,'.$userId,
            'password' => 'nullable|same:password_confirmar',
            'role' => 'required|exists:roles,name',
            'almacene_id' => 'required|exists:almacenes,id'
        ];
    }

    public function attributes(){
        return[
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'role' => 'rol',
            'almacene_id' => 'almacen'
        ];
    }

    public function messages(){
        return[
            'password.same' => 'Las contraseñas no coinciden'
        ];
    }
}