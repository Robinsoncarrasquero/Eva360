<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckEmailDns;
use Illuminate\Support\Arr;
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
                'relation.*' => 'required|max:15',
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
            'evaluacion.required'=>'E90(Supervisor + Manager ) / E360 (Supervisores + Pares + Subordinados + Autoevaluacion) / E180(Supervisores + Pares + Autoevaluacion)',
            'subproyecto.required'=> 'Sub Proyecto Requerido',

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
        $array_eva360 = ['AUTOEVALUACION', 'MANAGER' ,'SUPERVISOR','PAR','SUBORDINADO'];

        $collection = collect($array_eva360);



        $eva360=false;
        $eva180=false;
        $eva90=false;
        //Es una prueba de 360 grados
        $prueba="";
        $p90 = ['MANAGER' ,'SUPERVISOR'];
        $p180 = ['SUPERVISOR','PAR'];
        $p360 = ['SUPERVISOR','PAR','SUBORDINADO'];
        $prueba="eva180";
        foreach ($grouped as $key => $value) {
            if ($key=="SUBORDINADO"){
                $prueba = "eva360";
                break;
            }
            if ($key=="MANAGER"){
                $prueba = "eva90";
            }

        }

        switch ($prueba) {
            case 'eva360':
                //Evaluacion de 360
                $eva360=true;
                $array_eva360 = ['MANAGER' => 'MANAGER'];
                foreach ($grouped as $key => $value) {
                    if (($value->count()<2 && $key!='AUTOEVALUACION')  || (Arr::exists($array_eva360,$key)) || $grouped->count()<3){
                        $eva360=false;
                        break;
                    }
                }
                $prueba="eva360";
                break;
            case 'eva90':
                //Evaluacion de 90
                $eva90=true;
                $array_eva90 = ['AUTOEVALUACION'=>'AUTOEVALUACION','SUBORDINADO' => 'SUBORDINADO','PAR'=>'PAR'];
                foreach ($grouped as $key => $value) {
                    if ($value->count()>1 || $grouped->count()>3 || (Arr::exists($array_eva90,$key))){
                        $eva90=false;
                        break;
                    }
                }
                $prueba="eva90";
                break;
            default:
                //Evaluacion de 180
                $eva180=true;
                $array_eva180 = ['MANAGER' => 'MANAGER'];
                foreach ($grouped as $key => $value) {
                    if (($value->count()<2 && $key!='AUTOEVALUACION') || (Arr::exists($array_eva180,$key))){
                        $eva180=false;
                        break;
                    }
                }
                $prueba="eva180";
                break;
        }

        // if ($grouped->count()>2){

        //     //Evaluacion de 90
        //     $eva90=true;
        //     $array_eva90 = ['AUTOEVALUACION'=>'AUTOEVALUACION','SUBORDINADO' => 'SUBORDINADO','PAR'=>'PAR'];
        //     foreach ($grouped as $key => $value) {
        //         if ($value->count()>1 || $grouped->count()>3 || (Arr::exists($array_eva90,$key))){
        //             $eva90=false;
        //             break;
        //         }
        //     }
        //     $prueba="eva90";
        //     //Evaluacion de 360
        //     $array_eva360 = ['MANAGER' => 'MANAGER'];
        //     if (!$eva90){
        //         $eva360=true;
        //         foreach ($grouped as $key => $value) {
        //             if (($value->count()<2 && $key!='AUTOEVALUACION')  || (Arr::exists($array_eva360,$key))){
        //                 $eva360=false;
        //                 break;
        //             }
        //         }
        //         $prueba="eva360";
        //     }


        // }elseif ($grouped->count()>1){
        //     //Evaluacion de 180
        //     $eva180=true;
        //     $array_eva180 = ['MANAGER' => 'MANAGER'];
        //     foreach ($grouped as $key => $value) {
        //         if (($value->count()<2 && $key!='AUTOEVALUACION') || (Arr::exists($array_eva180,$key))){
        //             $eva180=false;
        //             break;
        //         }
        //     }
        //     $prueba="eva180";
        //     //Evaluacion de 90
        //     if (!$eva180){
        //         $eva90=true;
        //         $array_eva90 = ['SUBORDINADO' => 'SUBORDINADO','PAR'=>'PAR'];
        //         foreach ($grouped as $key => $value) {
        //             if ($value->count()>1 || $grouped->count()>3 || (Arr::exists($array_eva90,$key))){
        //                 $eva90=false;
        //                 break;
        //             }
        //         }
        //         $prueba="eva90";
        //     }


        // }

        if ($eva90 || $eva180 || $eva360){
            $this->merge([
                'evaluacion' =>$prueba ,
            ]);
        }

    }
}
