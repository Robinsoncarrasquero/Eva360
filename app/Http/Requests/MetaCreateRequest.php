<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaCreateRequest extends FormRequest
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
            'submetaName.*'=>'required',
            'submetaDescription.*'=>'required',
            'submetaRequerido.*'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Nombre es requerido',
            'description.required'=>'Descripcion es requerida',
            'nivelrequerido.required'=>'El nivel general es requerido y deber ser entero de 0 a 100',
            'tipo.required'=>'El tipo de meta es requerido',
            'submetaName.*.required'=>'La submeta es requerida',
            'submetaDescription.*.required'=>'La descripcion de la submeta es obligatoria',
            'submetaRequerido.*.required'=>'El nivel de cumplimiento es requerido',
        ];
    }
}
