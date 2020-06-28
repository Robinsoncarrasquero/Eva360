<?php

namespace App\Http\Requests;

use App\Competencia;
use App\EmailSend;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluador;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use App\Mail\EvaluacionEnviada;
use Illuminate\Support\facades\Log;
use Illuminate\Database\QueryException;

class EvaluacionCreateRequest extends FormRequest
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
            'competenciascheck'=>'required'
                        //
        ];
    }

    public function messages()
    {
        return [
            'competenciascheck.required' => 'Debe seleccionar al menos una competencia. Es mandatorio',
        ];
    }

    /**
     * Crea la evaluacion y la envia por correo
     */
    public function crearEvaluacion($evaluado_id){

        $competencias=$this->validated();

        //Generamos un array sigle
        $flattened = Arr::flatten($competencias);

        // Filtramos las competencias devueltas en el array genrado por Array flatten
        // y creamos una coleccion nueva del modelo con el metodo collecction only
        $datacompetencias = Competencia::all();
        $competencias = $datacompetencias->only($flattened);

        //Obeteremos el evaluado
        $evaluado = Evaluado::find($evaluado_id);

        //Obtenemos los evaluadores
        $evaluadores = Evaluado::find($evaluado->id)->evaluadores;
        //Recorremos los evaluadores y creamos la evaluacion para cada uno
        foreach($evaluadores as $evaluador){

            //Creamos la Evaluacion con los datos solo de las competencias
            foreach($competencias as $key=>$competencia){
                $evaluacion = new Evaluacion();
                $evaluacion->competencia_id=$competencia->id;
                $unevaluador = Evaluador::findOrFail($evaluador->id);

                try {
                //    $this->model->create($data);
                    $eva360=$unevaluador->evaluaciones()->save($evaluacion);

                } catch (QueryException $e) {
                    //dd($e);
                 return \redirect()->route('lanzar.index')->with('error','Error, Esta prueba ya habia sido lanzada..');

                }
            }


        }

        // //Enviamos el correo a los evaluadores
        foreach($evaluadores as $evaluador){
            $receivers = $evaluador->email;

            //Creamos un objeto para pasarlo a la clase Mailable
            $data = new EmailSend();
            $data->evaluadorName=$evaluador->name;
            $data->relation =$evaluador->relation;
            $data->token=$evaluador->remember_token;
            $data->siteweb =$this->root()."/evaluacion/$evaluador->remember_token/evaluacion";
            $data->name =$evaluado->name;

            Mail::to($receivers)->send(new EvaluacionEnviada($data));
        }



    }

}
