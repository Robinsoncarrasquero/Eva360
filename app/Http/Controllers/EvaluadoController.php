<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\FileJson;
use App\Evaluado;
use App\Evaluador;
use Illuminate\Database\QueryException;

class EvaluadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluados=Evaluado::paginate(10);

        return \view('evaluado.index',compact('evaluados'));
    }

    /**
     * Show the form for creating a new evaluado.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pathFile = 'config/evaluado.json';
        if (Storage::exists($pathFile)){
           $json = Storage::disk('local')->get($pathFile);
           $fileName='evaluado.json';
           //Generamos un array
           $evaluadoArray=collect(json_decode($json));

           return \view('evaluado.create',compact('evaluadoArray','fileName'));
        }
        \abort(404);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileJson $fileJsonRequest)
    {
        //
        $name=$fileJsonRequest->input('name.*');
        $relation=$fileJsonRequest->input('relation.*');
        $email=$fileJsonRequest->input('email.*');


        $fileName='evaluado.json';
        $pathFile = 'config/.'.$fileName;
        if (Storage::exists($pathFile)){
            $evaluado= new Evaluado();
            $evaluado->name=$fileJsonRequest->nameevaluado;
            $evaluado->status=0;
            $evaluado->word_key=$fileName;
            $evaluado->save();

            for ($i=0; $i < count($name); $i++) {
                $evaluador= new Evaluador();
                $evaluador->name=$name[$i];
                $evaluador->email=$email[$i];
                $evaluador->relation=$relation[$i];
                $evaluador->remember_token= Str::random(32);
                $evaluador->status=0;
                $evaluado->evaluadores()->save($evaluador);
            }

        }else{
            \abort(404);
        }

        return redirect()->route('lanzar.index')
        ->withSuccess('Evaluado Procesado con exito!!. Ya estamos listo para lanzar una nueva Evaluacion, rapidamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($evaluado)
    {
        $evaluado = Evaluado::find($evaluado);
        try {
            $evaluado->delete();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Eliminar este registro, tiene restricciones asociadas');
        }
        return redirect('evaluado')->withSuccess('El Evaluado ha sido eliminado con exito!!');
    }


}
