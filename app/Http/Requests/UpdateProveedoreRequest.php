<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProveedoreRequest extends FormRequest
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
        $proveedore = $this->route('proveedore');
        $personaId = $proveedore->id;
        return [
            'razon_social' => 'required|max:150',
            'direccion' => 'required|max:80',
            'num_documento' => 'required|max:20|unique:proveedores,num_documento,'.$personaId,
            'telefono' => 'nullable|max:11'
        ];
    }

    public function attributes(){
        return[
            'num_documento' => 'número documento'
        ];
    }
}