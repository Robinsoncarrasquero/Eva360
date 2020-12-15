<?php

namespace App\Http\Controllers;

use App\Frecuencia;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class FrecuenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $frecuencias=Frecuencia::all();
        return \view('frecuencia.index',compact('frecuencias'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('frecuencia.create');

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
            'name'=>'required',
            'description'=>'required|max:255',
            'valor'=>'required|integer|between:0,100',
            ],[
                'name.required'=>'Nombre de la Frecuencia es requerido',
                'description.required'=>'La descripcion de la Frecuencia es requerida',
                'valor.required'=>'El valor de la Frecuencia debe estar between:min,max',
            ],
        );

        try {

            $frecuencia = new Frecuencia();
            $frecuencia->name = $request->name;
            $frecuencia->description = $request->description;
            $frecuencia->valor= $request->valor;
            $frecuencia->save();

        } catch (QueryException $e) {
            dd($e);
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. La frecuencia debe ser unica, no se permite duplicados.');
        }

        return \redirect('frecuencia')->withSuccess('Frecuencia : '.$request->name.' Registrada exitosamente');
        //
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
    public function edit($frecuencia)
    {
        //
        $frecuencia = Frecuencia::findOrFail($frecuencia);
        return \view('frecuencia.edit',\compact('frecuencia'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $frecuencia)
    {

       //

       $request->validate([
            'name'=>'required|unique:frecuencias,name,'.$frecuencia,
            'valor'=>'required|integer|between:0,100',
            'description'=>'required',
            ],[
                'name.required'=>'La descripcion de la Frecuencia es requerida',
                'name.unique'=>'El nombre ya esta registrado en la tabla.',
                'valor.between'=>'El valor de la frecuencia debe estar  entre :min y :max.',
                'description.required'=>'La descripcion de la Frecuencia es requerida',
            ],
        );

        try {

            $frecuencia = Frecuencia::findOrFail($frecuencia);
            $frecuencia->name = $request->name;
            $frecuencia->description = $request->description;
            $frecuencia->valor = $request->valor;
            $frecuencia->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Modificar este registro. La frecuencia debe ser unica, no se permite duplicados.');
        }

        return \redirect('frecuencia')->withSuccess('Frecuencia : '.$request->name.' Actualizada exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($frecuencia)
    {
        //
        $frecuencia = Frecuencia::find($frecuencia);
        try {
            $frecuencia->delete();
            $success = true;
            $message = "Frecuencia eliminada exitosamente";
        } catch (QueryException $e) {
            $success = false;
            $message = "No se puede eliminar esta Frecuencia, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible eliminar la frecuencia, tiene restricciones con las evaluaciones.');
        }
         //Return response
         return \response()->json([
            'success'=>$success,
            'message'=>$message,
        ]);
        // return redirect('frecuencia')->withSuccess('La frecuencia ha sido eliminada con exito!!');
    }
}
