<?php

namespace App\Http\Controllers;

use App\Medida;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RealRashid\SweetAlert\Facades\Alert;

class MedidaController extends Controller
{
    //
     //
    /**
     * Display a listing of the medidas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $medidas=Medida::simplePaginate(5);
        return \view('medidas.index',compact('medidas'));

    }

    /**
     * Show the form for creating a new medida.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('medidas.create');
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
            $medida = new Medida();
            $medida->name = $formrequest->name;
            $medida->medida = $formrequest->medida;
            $medida->description = $formrequest->description;
            $medida->save();
         } catch (QueryException $e) {
            Alert::error('Medicion',Arr::random(['duplicada','Repetida']));
            return redirect()
            ->back()->withErrors('Error imposible Guardar este registro. El Nombre de la medicion debe ser unico, no se permite duplicados.');
        }


        Alert::success('Medicion '.$formrequest->name,Arr::random(['Registrada exitosamente','Registro Exitoso']));
        return \redirect('medida')->withSuccess('Medicion creada exitosamente : '.$formrequest->name.' Registrado exitosamente');
    }

    /**
     * Show the form for editing the specified medida.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($medida)
    {
        $medida = Medida::findOrFail($medida);


        return \view('medidas.edit',\compact('medida'));
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

        $medida = Medida::findOrFail($medida);

        try {
            $medida->name=$formrequest->name;
            $medida->medida=$formrequest->medida;
            $medida->description=$formrequest->description;
            $medida->save();

        } catch (QueryException $e) {
            Alert::error('Medicion '.$formrequest->name,Arr::random(['Duplicada','Registro ya existe']));

            return redirect()->back()
            ->withErrors('Error imposible guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }
        Alert::success('Medicion '.$formrequest->name,Arr::random(['Bien','Excelente']));

        return \redirect('medida')->withSuccess('Medicion : '.$formrequest->name.' Actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($medida)
    {
        $medida = Medida::find($medida);
        try {
            $medida->delete();
            $success = true;
            $message = "Medicion eliminada exitosamente";
        } catch (QueryException $e) {
            $success = false;
      	    $message = "No se puede eliminar esta medicion, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas evaluaciones realizadas.');
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

        // return redirect('medida')->withSuccess('La medida ha sido eliminada con exito!!');
    }
}
