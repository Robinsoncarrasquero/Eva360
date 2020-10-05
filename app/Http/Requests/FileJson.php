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
                'evaluacion'=>'required'

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
            'evaluacion.required'=>'Error la evaluacion 360(Supervisores + Pares + Subordinados) 180(Supervisores + Pares) 90(Jefe + Supervisor)'
        ];
    }
    public function save(){

    }
    //Validamos los tipos de pruebas
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
