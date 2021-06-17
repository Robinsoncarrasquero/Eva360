<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Grado;
use App\Competencia;

class CompetenciaCreateRequest extends FormRequest
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
            'gradoName.*'=>'required',
            'gradoDescription.*'=>'required',
            'gradoPonderacion.*'=>'required',

        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Nombre es requerido',
            'description.required'=>'Descripcion es requerida',
            'nivelrequerido.required'=>'El nivel es requerido y deber ser entero de 0 a 100',
            'tipo.required'=>'El tipo es requerido',
            'gradoName.*.required'=>'Los grados de las competencias son requeridos',
            'gradoDescription.*.required'=>'Las preguntas de la competencias son requerida',
            'gradoPonderacion.*.required'=>'Las ponderaciones de cada grado son requeridas',


        ];
    }


}
