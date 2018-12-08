<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'taxNumber' => 'required|numeric|digits:11|unique:suppliers',
            'bussinesName' => 'required|string|min:3|max:100',
            'name' => 'required|string|max:50',
            'abbreviation' => 'string|max:10',

            'first_name' => 'string|max:20',
            'middle_name' => 'string|max:20',
            'last_name' => 'string|max:20',
            'email' => 'string|max:60',
            'website' => 'string|max:100',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'size' => 'El campo :attribute debe tener un tamaño de :size',
            'min' => 'El campo :attribute debe tener un minimo de :min',
            'digits' => 'El campo :attribute debe tener :digits digitos',
            'email' => 'El campo :attribute debe ser una dirección valida',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'taxNumber' => 'CUIT',
            'bussinesName' => 'razon social',
            'name' => 'nombre',
            'abbreviation' => 'abreviatura',
            'first_name' => 'primer nombre',
            'middle_name' => 'segundo nombre',
            'last_name' => 'apellido'
        ];
    }
}
