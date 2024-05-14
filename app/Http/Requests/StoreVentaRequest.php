<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
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
            'cliente_id' => 'required|exists:clientes,id',
            'total' => 'required',
            'fecha_hora' => 'required',
            'impuesto' => 'required',
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
            'cliente_id.required' => 'Debe seleccionar un Cliente',
            'comprobante_id.required' => 'Debe seleccionar un Comprobante'
        ];
    }
}