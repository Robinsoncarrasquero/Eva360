<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Competencia;
use App\Grado;
use App\Tipo;
use App\Http\Requests\CompetenciaCreateRequest;
use Brick\Math\BigInteger;
use Brick\Math\BigNumber;
use Illuminate\Support\Facades\Storage;

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
        $competencias=Competencia::simplePaginate(5);
        return \view('competencia.index',compact('competencias'));

    }

    /**
     * Show the form for creating a new competencia.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //Buscamos el json configurado con la tabla de grado
        $jsonfile = Storage::disk('local')->get('config/grado.json');

        //Convertimos en una array
        $filegrado=collect(json_decode($jsonfile));
        $tipos = Tipo::all();

        return view('competencia.create',compact('filegrado','tipos'));
    }

    /**
     * Store a newly created competencia in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompetenciaCreateRequest  $formrequest)
    {
        $competencia = new Competencia();
        $competencia->name=$formrequest->name;
        $competencia->description=$formrequest->description;
        $competencia->nivelrequerido = $formrequest->nivelrequerido;
        $competencia->tipo_id = $formrequest->tipo;
        $competencia->save();

        //Creamos los grados con las preguntas
        $gName=$formrequest->input('gradoName.*');
        $gDescription=$formrequest->input('gradoDescription.*');
        $gPonderacion=$formrequest->input('gradoPonderacion.*');

        for ($i=0; $i < count($gName); $i++) {
            $grado= new Grado();
            $grado->grado=$gName[$i];
            $grado->description=$gDescription[$i];
            $grado->ponderacion=$gPonderacion[$i];
            $competencia->grados()->save($grado);
        }
        return \redirect('competencia')->withSuccess('Competencia creada exitosamente');

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
        $tipos = Tipo::all();

        return \view('competencia.edit',\compact('competencia','tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompetenciaCreateRequest $formrequest, $competencia)
    {

        $competencia = Competencia::findOrFail($competencia);

        try {
            $competencia->name=$formrequest->name;
            $competencia->description=$formrequest->description;
            $competencia->nivelrequerido = $formrequest->nivelrequerido;
            $competencia->tipo_id = $formrequest->tipo;
            $competencia->save();

            //Creamos los grados con las preguntas
            $gDescription=$formrequest->input('gradoDescription.*');
            $gPonderacion=$formrequest->input('gradoPonderacion.*');
            $gradoid=$formrequest->input('gradoid');
            for ($i=0; $i < count($gradoid); $i++) {
                $grado= Grado::find($gradoid[$i]);
                //$grado->grado=$gName[$i];
                $grado->description=$gDescription[$i];
                $grado->ponderacion=$gPonderacion[$i];
                $grado->save();
            }

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }

        return \redirect('competencia')->withSuccess('Competencia : '.$formrequest->name.' Actualizada exitosamente');
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
            return redirect()->back()
            ->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas evaluaciones realizadas.');
        }

        return redirect('competencia')->withSuccess('La Competencia ha sido eliminada con exito!!');
    }
}
