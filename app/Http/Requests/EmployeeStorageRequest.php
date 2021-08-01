<?php

namespace App\Http\Requests;
class EmployeeStorageRequest extends BaseFormRequest
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
            'company_id' =>[
                'required',              
            ],
            'first_name' =>[
                'required',              
            ],
            'last_name' =>[
                'required',              
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
            'company_id.required' => 'La empresa es obligatoria',
            'first_name.required' => 'El nombre es obligatorio',
            'last_name.required' => 'El apellido es obligatorio',
            'email.email' => 'Email Inválido',
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
            'first_name' => 'trim|escape',
            'last_name' => 'trim|escape',
            'email' => 'trim|escape',
            'phone' => 'trim|escape',
        ];
    }
}
