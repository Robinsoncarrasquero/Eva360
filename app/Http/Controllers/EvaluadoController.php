<?php

namespace App\Http\Controllers;

use App\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\FileJson;
use App\Evaluado;
use App\Evaluador;
use App\SubProyecto;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

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
    public function create($subproyecto_id)
    {

        $subproyecto=SubProyecto::find($subproyecto_id);
        if (!$subproyecto){
            \abort(404);
        }
        $pathFile = 'config/evaluado.json';
        if (Storage::exists($pathFile)){
           $json = Storage::disk('local')->get($pathFile);
           $fileName='evaluado.json';
           //Generamos un arrayin
           $evaluadoArray=collect(json_decode($json));
           $cargos = Cargo::all();
           return \view('evaluado.create',compact('evaluadoArray','fileName','cargos','subproyecto'));
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
        $prueba=$fileJsonRequest->input('evaluacion');

        $fileName='evaluado.json';
        $pathFile = 'config/'.$fileName;
        if (Storage::exists($pathFile)){
            $evaluado= new Evaluado();
            $evaluado->name=$fileJsonRequest->nameevaluado;
            $evaluado->status=0;
            $evaluado->word_key= $prueba;
            $evaluado->cargo_id=$fileJsonRequest->cargo;
            $evaluado->subproyecto_id=$fileJsonRequest->subproyecto;
            $evaluado->save();

            for ($i=0; $i < count($name); $i++) {
                $evaluador= new Evaluador();
                $evaluador->name=$name[$i];
                $evaluador->email=$email[$i];
                $evaluador->relation=Str::of($relation[$i])->ucfirst();
                $evaluador->remember_token= Str::random(32);
                $evaluador->status=0;
                $evaluado->evaluadores()->save($evaluador);
            }

        }else{
            \abort(404);
        }

        return redirect()->route('proyectoevaluado.index')
        ->withSuccess('Evaluado creado con exito!!. Ya estamos listo para lanzar una evaluacion.');
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
        $evaluado = Evaluado::findOrFail($id);
        return \view('evaluado.edit',\compact('evaluado'));

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
            ->withErrors('Error imposible Eliminar este registro, tiene un modelo de competencias lanzado');
        }
        return redirect()->back()->withSuccess('El Evaluado ha sido eliminado con exito!!');
    }


}
