<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
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
        return [
            'razon_social' => 'required|max:150',
            'direccion' => 'required|max:80',
            'num_documento' => 'required|max:20|unique:clientes,num_documento',
            'telefono' => 'nullable|max:11',
            'documento_id' => 'required',
            'estado' => 'required'
        ];
    }

    public function attributes(){
        return[
            'num_documento' => 'número documento'
        ];
    }
}