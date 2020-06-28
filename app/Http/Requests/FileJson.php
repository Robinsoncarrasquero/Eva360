<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckEmailDns;
use Illuminate\Support\Facades\Validator;

class FileJson extends FormRequest
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
                'name.*'       => 'required|max:50',
                'relation.*' => 'required|max:20',
                'email.*' => [new CheckEmailDns()],

            ];
    }

    public function messages()
    {
        return [
            'name.*'=> 'El Nombre es requerido, debe indicarlo correctamente',
            'email.*'=> 'El Email is requerido, debe especificarlo correctamente',
            'relation.*' => 'La Relation es requerida, debe ingresar un tipo de relacion (parner, supervisor,externo,etc)',
        ];
    }
    public function save(){


    }


}
