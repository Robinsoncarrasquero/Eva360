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
                'nameevaluado'=>'required',
                'cargo'=>'required',
                'name.*'       => 'required|max:50',
                'relation.*' => 'required|max:10',
                'email.*' => 'required',
                'email.*' => [new CheckEmailDns()],

            ];
    }

    public function messages()
    {
        return [
            'nameevaluado.required'=> 'El Nombre del evaluado es requerido, debe indicarlo correctamente',
            'cargoevaluado.required'=> 'El Cargo del evaluado es requerido, debe indicarlo correctamente',
            'name.*.required'=> 'El Nombre es requerido, debe indicarlo correctamente',
            'email.*.required'=> 'El Email is requerido, debe especificarlo correctamente',
            'relation.*.required' => 'La Relation es requerida, debe ingresar un tipo de relacion (parner, supervisor,externo,etc)',
            'relation.*.max' => 'La Relacion (:attribute) debe tener un maximo de 10 caracteres',
            'email.*.CheckEmailDns' => 'Email No valido debe ingresar un nombre de dominio correctamente',
        ];
    }
    public function save(){


    }


}
