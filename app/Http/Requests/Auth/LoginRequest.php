<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest
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
            'email' =>[
                'required',
            ],
            'password' =>[
                'required'               
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
            'email.required' => 'El correo es obligatorio',
            'password.required' => 'La contraseña es obligatoria'
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
            'email' => 'trim|escape',
            'password' => 'trim|escape',
        ];
    }
}
