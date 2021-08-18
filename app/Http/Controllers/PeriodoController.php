<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    //
    public function index()
    {
        $periodos=Periodo::simplePaginate(25);
        return \view('periodo.index',compact('periodos'));
    }

    /**
     * Show the form for creating a new periodo.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('periodo.create');
    }

    /**
     * Store a newly created periodo in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $formrequest)
    {
        try {
            $periodo = new periodo();
            $periodo->name = $formrequest->name;
            $periodo->description = $formrequest->description;
            $periodo->save();
         } catch (QueryException $e) {
            return redirect()
            ->back()->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('periodo')->withSuccess('Registro : '.$formrequest->name.' creado exitosamente');
    }

    /**
     * Show the form for editing the specified periodo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($periodo)
    {
        $periodo = periodo::findOrFail($periodo);
        return \view('periodo.edit',\compact('periodo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $formrequest, $periodo)
    {
        $periodo = periodo::findOrFail($periodo);
        try {
            $periodo->name=$formrequest->name;
            $periodo->description=$formrequest->description;
            $periodo->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }
        return \redirect('periodo')->withSuccess('Registro : '.$formrequest->name.' actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($periodo)
    {
        $periodo = periodo::find($periodo);
        try {
            $periodo->delete();
            $success = true;
            $message = "Registro eliminado exitosamente";
        } catch (QueryException $e) {
            $success = false;
      	    $message = "No se puede eliminar este registro, data restringida";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
}
