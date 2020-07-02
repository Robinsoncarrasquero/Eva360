<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Competencia;

class CompetenciaController extends Controller
{
    /**
     * Display a listing of the competencias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $competencias=Competencia::all();

        return \view('competencia.index',compact('competencias'));

    }

    /**
     * Show the form for creating a new competencia.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('competencia.create');
    }

    /**
     * Store a newly created competencia in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'nivelrequerido'=>'required|integer|between:0,100',
            'tipo'=>'required'
        ],[
            'name.required'=>'Nombre es requerido',
            'description.required'=>'Descripcion es requerida',
            'nivelrequerido.required'=>'El nivel es requerido y deber ser entero de 0 a 100',
            'tipo.required'=>'El tipo es requerido'
        ]);

        $competencia = new Competencia();

        $competencia->name=$request->name;
        $competencia->description=$request->description;
        $competencia->nivelrequerido = $request->nivelrequerido;
        $competencia->tipo = $request->tipo;
        $competencia->save();

        return \redirect('competencia')->withSuccess('Competencia creada exitosamente');



    }

    /**
     * Display the specified competencia.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified competencia.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($competencia)
    {
        $competencia = Competencia::findOrFail($competencia);
        return \view('competencia.edit',\compact('competencia'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $competencia)
    {
        //
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'nivelrequerido'=>'required|integer|between:0,100',
            'tipo'=>'required'
        ],[
            'name.required'=>'Nombre es requerido',
            'description.required'=>'Descripcion es requerida',
            'nivelrequerido.required|integer'=>'El nivel es requerido y deber ser entero de 0 a 100',
            'tipo.required'=>'El tipo es requerido'
        ]);

        $competencia = Competencia::findOrFail($competencia);

        try {
            $competencia->name=$request->name;
            $competencia->description=$request->description;
            $competencia->nivelrequerido = $request->nivelrequerido;
            $competencia->tipo = $request->tipo;
            $competencia->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro, revise los datos e intente nuevamante.');
        }


        return \redirect('competencia')->withSuccess('Competencia : '.$request->name.' Actualizada exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($competencia)
    {

        $competencia = Competencia::find($competencia);
        try {
            $competencia->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas evaluaciones realizadas.');
        }

        return redirect('competencia')->withSuccess('Competencia eliminada con exito');

    }
}
