<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Tipo;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos=Tipo::all();
        return \view('tipo.index',compact('tipos'));
    }

    /**
     * Show the form for creating a new tipo de competencica.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'tipo'=>'required',
            ],[
                'tipo.required'=>'El tipo de competencia es requerido'
            ],
        );

        try {

            $tipo = new Tipo();
            $tipo->tipo=$request->tipo;
            $tipo->save();

        } catch (QueryException $e) {
            Alert::error($request->tipo,Arr::random(['Duplicada','Registro Ya existe']));

            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Tipo debe ser unico, no se permite duplicados.');
        }

        Alert::success('Registro '.$request->tipo,Arr::random(['Exitoso','Excelente','Perfecto','Muy Bien']));

        return redirect('tipo')->withSuccess('Tipo de Competencia : '.$request->tipo.' Registrado exitosamente');

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
     * Show the form for editing el tipo de competencia.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tipo)
    {
        $tipo = Tipo::findOrFail($tipo);
        return \view('tipo.edit',\compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tipo)
    {
        //
        $request->validate([
            'tipo'=>'required',
            ],[
                'tipo.required'=>'El tipo de competencia es requerido'
            ],
        );

        try {
            $tipo = Tipo::findOrFail($tipo);
            $tipo->tipo=$request->tipo;
            $tipo->save();
        } catch (QueryException $e) {
            Alert::error($request->tipo,Arr::random(['Duplicada','Registro Ya existe']));
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Tipo debe ser unico, no se permite duplicados.');
        }
        Alert::success($request->tipo,Arr::random(['Registro actualizado','Excelente actualizado']));

        return \redirect('tipo')->withSuccess('Tipo de Competencia : '.$request->tipo.' Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tipo)
    {
        //
        $tipo = Tipo::find($tipo);
        try {
            $tipo->delete();
            $success = true;
            $message = "Tipo de Competencia eliminado exitosamente";
        } catch (QueryException $e) {
            $success = false;
            $message = "No se puede eliminar este tipo de Competencia, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas Competencias.');
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

        // return redirect('tipo')->withSuccess('El tipo de Competencia ha sido eliminado con exito!!');

    }
}
