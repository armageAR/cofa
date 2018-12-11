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
            'taxNumber' => 'required|numeric|digits:11|unique:suppliers,taxNumber,' . $this->id,
            'bussinesName' => 'required|string|min:3|max:100',
            'name' => 'required|string|max:50',
            'abbreviation' => 'string|max:10',
            //Contact
            'contact.first_name' => 'required|string|max:20',
            'contact.middle_name' => 'string|max:20',
            'contact.last_name' => 'required|string|max:20',
            'contact.email' => 'required|email|max:60',
            'contact.website' => 'string|max:100',
            //address
            'address.street' => 'required|string|max:60',
            'address.number' => 'required|string|max:20',
            'address.city' => 'required|string|max:60',
            'address.state' => 'required|string|max:60',
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
            'unique' => 'El campo :attribute ya se encuentra registrado en la base de datos',
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
