<?php

namespace App\Http\Controllers;

use App\Configuracion;
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

        // $request->validate([
        //     'sendsms'=>'required',
        //     'sendemail'=>'required',
        //     'autoevaluacion'=>'required',
        //     ],[
        //         'sendsms.required'=>'SMS es requerido',
        //         'sendemail.required'=>'Enviar email es requerido',
        //         'autoevaluacion.required'=>'Promediar autoevaluacion es requerido',
        //     ],

        // );

        try {

            $record = Configuracion::first();
            $record->sms=$request->sendsms ? 1 : 0;
            $record->email= $request->sendemail ? 1 : 0;
            $record->promediarautoevaluacion= $request->autoevaluacion ? 1 : 0;
            $record->save();

        } catch (QueryException $e) {
            dd($e);
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. Algo no esta bien con la configuracion.');
        }

        return \redirect('login')->withSuccess('Configuracion: Actualizada correctamente');
    }
}
