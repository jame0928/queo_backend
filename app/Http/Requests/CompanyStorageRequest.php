<?php

namespace App\Http\Requests;

class CompanyStorageRequest extends BaseFormRequest
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
            'name' =>[
                'required',              
            ],
            'email' =>[
                'email',                
            ],            
            'file' =>[
                'dimensions:min_width=100,min_height=100',
            ],            
        ];
    }


    /**
     *  Custom messages for validation errors
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'email.email' => 'Email Inválido',
            'file.dimensions' => 'Las dimensiones del logo deben ser de mínimo 100 de Alto x 100 de Ancho'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => 'trim|escape',
            'email' => 'trim|escape',
            'website' => 'trim|escape',
        ];
    }
}
