<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
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
            'codigo_producto' => 'nullable|max:150',
            'descripcion' => 'required|max:250',
            'procedencia' => 'nullable|max:100',
            'codigo_barra' => 'required|max:10|unique:productos,codigo_barra',
            'image_data' => 'nullable|image|mimes:png, jpeg, jpg|max:2048',
            'marca_id' => 'required',
            'categoria_id' => 'required'
        ];
    }

    public function attributes(){
        return[
            'descripcion' => 'descripción',
            'image_data' => 'imagen'
        ];
    }

    public function messages(){
        return[
            'marca_id.required' => 'Debe seleccionar una Marca',
            'categoria_id.required' => 'Debe seleccionar una Categoría'
        ];
    }
}