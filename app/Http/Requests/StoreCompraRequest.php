<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
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
            'proveedore_id' => 'required|exists:proveedores,id',
            'comprobante_id' => 'required|exists:comprobantes,id',
            'num_comprobante' => 'required|max:250',
            'impuesto' => 'required',
            'total' => 'required',
            'fecha' => 'required',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function attributes(){
        return[
            'num_comprobante' => 'número comprobante'
        ];
    }

    public function messages(){
        return[
            'proovedore_id.required' => 'Debe seleccionar un Proveedor',
            'comprobante_id.required' => 'Debe seleccionar un Comprobante'
        ];
    }
}