<?php

namespace App\Http\Controllers;

use App\GrupoCompetencia;
use App\Http\Requests\GrupoCompetenciaRequest;
use App\Tipo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GrupoCompetenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competencias=GrupoCompetencia::simplePaginate(15);


        return \view('grupocompetencia.index',compact('competencias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipos = Tipo::all();
        return view('grupocompetencia.create',compact('tipos'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoCompetenciaRequest $formrequest)
    {
        //
        $competencia = new GrupoCompetencia();
        $competencia->name=$formrequest->name;
        $competencia->description=$formrequest->description;
        $competencia->nivelrequerido = $formrequest->nivelrequerido;
        $competencia->tipo_id = $formrequest->tipo;
        $competencia->save();

        return \redirect('grupocompetencia')->withSuccess('Grupo de Competencia creado exitosamente');

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
    public function destroy($id)
    {
        $competencia = GrupoCompetencia::find($id);
        try {
            $competencia->delete();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas Competencias.');
        }

        return redirect('grupocompetencia')->withSuccess('El Grupo de las Competencias ha sido eliminado con exito!!');
    }
}
