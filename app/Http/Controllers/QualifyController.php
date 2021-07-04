<?php

namespace App\Http\Controllers;

use App\Qualify;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;

class QualifyController extends Controller
{
    //
    /**
     * Display a listing of the medidas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medidas=Qualify::simplePaginate(5);
        return \view('qualify.index',compact('medidas'));
    }

    /**
     * Show the form for creating a new medida.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('qualify.create');
    }

    /**
     * Store a newly created medida in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $formrequest)
    {
        try {
            $medida = new Qualify();
            $medida->name = $formrequest->name;
            $medida->nivel = $formrequest->nivel;
            $medida->description = $formrequest->description;
            $medida->color = $formrequest->color;
            $medida->save();
         } catch (QueryException $e) {
            return redirect()
            ->back()->withErrors('Error imposible Guardar este registro. El Nombre de la Calificacion debe ser unico, no se permite duplicados.');
        }
        return \redirect('qualify')->withSuccess('Calificacion creada exitosamente : '.$formrequest->name.' Registrado exitosamente');
    }

    /**
     * Show the form for editing the specified medida.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($medida)
    {
        $medida = Qualify::findOrFail($medida);
        return \view('qualify.edit',\compact('medida'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $formrequest, $medida)
    {
        $medida = Qualify::findOrFail($medida);
        try {
            $medida->name=$formrequest->name;
            $medida->nivel=$formrequest->nivel;
            $medida->description=$formrequest->description;
            $medida->color = $formrequest->color;
            $medida->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }
        return \redirect('qualify')->withSuccess('Calificacion : '.$formrequest->name.' Actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($medida)
    {
        $medida = Qualify::find($medida);
        try {
            $medida->delete();
            $success = true;
            $message = "Calificacion eliminada exitosamente";
        } catch (QueryException $e) {
            $success = false;
      	    $message = "No se puede eliminar esta calificacion, data restringida";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
}
