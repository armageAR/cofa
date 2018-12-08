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
            //'taxNumber' => 'required|numeric|size:11|unique:suppliers',
            'bussinesName' => 'required|string|min:3|max:100',
            'name' => 'required|string|max:50',
            'abbreviation' => 'string|max:10'
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
            'abbreviation' => 'abreviatura'
        ];
    }
}
