<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class ConfiguracionController extends Controller
{
    //
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $record = Configuracion::firstOrCreate(
            ['name'=>'talent360'],
            [
            'sms'=>0,
            'email'=>0,
            'promediarautoevaluacion'=>0
            ]

        );

        return \view('configuracion.edit',\compact('record'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $request->validate([
            'manager'=>'required|max:15,string',
            'supervisor'=>'required|max:15,string',
            'supervisores'=>'required|max:15,string',
            'pares'=>'required|max:15,string',
            'subordinados'=>'required|max:15,string',
            'autoevaluacion'=>'required|max:15,string',
            ],[
                'manager.required'=>'El titulo para un manager es requerido',
                'supervisor.required'=>'El titulo para un supervisor es requerido',
                'supervisores.required'=>'El titulo para el grupo supervisores es requerido',
                'pares.required'=>'El titulo para el grupo pares es requerido',
                'subordinados.required'=>'El titulo para el grupo subordinados es requerido',
                'autoevaluacion.required'=>'El titulo para la autoevaluacion es requerido',

            ],

        );


        try {

            $record = Configuracion::first();
            $record->sms=$request->sendsms ? 1 : 0;
            $record->email= $request->sendemail ? 1 : 0;
            $record->promediarautoevaluacion= $request->promediarautoevaluacion ? 1 : 0;
            $record->manager= $request->manager;
            $record->supervisor = $request->supervisor;
            $record->supervisores = $request->supervisores;
            $record->pares = $request->pares;
            $record->subordinados = $request->subordinados;
            $record->autoevaluacion = $request->autoevaluacion;
            $record->save();

        } catch (QueryException $e) {

            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. Algo no esta bien con la configuracion.');
        }

        return \redirect('login')->withSuccess('Configuracion: Actualizada correctamente');
    }
}
