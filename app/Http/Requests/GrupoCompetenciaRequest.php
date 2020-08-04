<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoCompetenciaRequest extends FormRequest
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
            'name'=>'required',
            'description'=>'required',
            'nivelrequerido'=>'required|integer|between:0,100',
            'tipo'=>'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required'=>'Nombre es requerido',
            'description.required'=>'Descripcion es requerida',
            'nivelrequerido.required'=>'El nivel es requerido y deber ser entero de 0 a 100',
            'tipo.required'=>'El tipo es requerido',
        ];
    }
}
