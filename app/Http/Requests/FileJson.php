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
                //'email.*' => [new CheckEmailDns()],
                'email.*' => 'email:rfc,dns',
                'evaluacion'=>'required'

            ];
    }

    public function messages()
    {
        return [
            'nameevaluado.required'=> 'El Nombre de Evaluado es requerido.',
            'cargoevaluado.required'=> 'El Cargo de Evaluado es requerido.',
            'name.*.required'=> 'El Nombre de Evaluador es requerido.',
            'email.*.required'=> 'El e-mail es requerido, debe especificarlo correctamente',
            'relation.*.required' => 'La Relation es requerida.',
            'relation.*.max' => 'La Relacion (:attribute) debe tener un maximo de 15 caracteres',
            //'email.*.CheckEmailDns' => 'Debe especificar una direccion de correo valida',
            'email.*' => 'Debe especificar una direccion de correo valida :attribute',
            'evaluacion.required'=>'E90(Jefe + Super) / E360 (Super + Pares + Subordinados) / E180(Super + Pares) / '
        ];
    }
    protected function prepareForValidation()
    {

        $relation=$this->input('relation.*');
        foreach ($relation as $value) {
            $arrayrelation[]=['relation'=>\strtoupper($value)];
        }
        $colrelation = \collect($arrayrelation);
        $grouped = $colrelation->groupBy('relation');


        $eva360=false;
        $eva180=false;
        $eva90=false;
        //Es una prueba de 360 grados
        $prueba="";

        if ($grouped->count()>2){
            //Evaluacion de 360
            $eva360=true;
            foreach ($grouped as $key => $value) {
                if ($value->count()<2 && $key!='AUTO'){
                    $eva360=false;
                }
            }
            $prueba="eva360";
        }elseif ($grouped->count()>1){
            //Evaluacion de 180
            $eva180=true;
            foreach ($grouped as $key => $value) {
                if ($value->count()<2){
                    $eva180=false;
                }
            }
            $prueba="eva180";
            //Evaluacion de 90
            if (!$eva180){
                $eva90=true;
                foreach ($grouped as $key => $value) {
                    if ($value->count()>1){
                        $eva90=false;
                    }
                }
                $prueba="eva90";
            }

        }

        if ($eva90 || $eva180 || $eva360){
            $this->merge([
                'evaluacion' =>$prueba ,
            ]);
        }

    }
}
