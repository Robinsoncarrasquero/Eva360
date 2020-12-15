<?php

namespace App\Http\Controllers;

use App\Proyecto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=Proyecto::all();
        return \view('proyecto.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proyecto.create');
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
            'description'=>'required',
            ],[
                'name.required'=>'Nombre es requerido',
                'description.required'=>'Descripcion es requerida'
            ],
        );

        try {
            $record = new Proyecto();
            $record->name=$request->name;
            $record->description=$request->description;
            $record->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('proyecto')->withSuccess('Proyecto : '.$request->name.' Registrado exitosamente');

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
        $record = Proyecto::findOrFail($id);
        return \view('proyecto.edit',\compact('record'));
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
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            ],[
                'name.required'=>'Nombre es requerido',
                'description.required'=>'Descripcion es requerida'
            ],

        );

        try {

            $record = Proyecto::findOrFail($id);
            $record->name=$request->name;
            $record->description= $request->description;
            $record->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }

        return \redirect('proyecto')->withSuccess('Proyecto : '.$request->name.' Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Proyecto::find($id);
        try {
            $record->delete();
            $success = true;
            $message = "Proyecto eliminado exitosamente";
        } catch (QueryException $e) {
            $success = false;
            $message = "No se puede eliminar este proyecto, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con otros datos asociados.');
        }
        //Return response
        return \response()->json([
            'success'=>$success,
            'message'=>$message,
        ]);
        // return redirect('proyecto')->withSuccess('Registro ha sido eliminado con exito!!');
    }
}
