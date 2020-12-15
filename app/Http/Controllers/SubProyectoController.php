<?php

namespace App\Http\Controllers;

use App\Proyecto;
use App\SubProyecto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SubProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records= SubProyecto ::simplePaginate(10);
        return \view('subproyecto.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyectos=Proyecto::all();

        return view('subproyecto.create',\compact("proyectos"));
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
            $record = new Subproyecto();
            $record->name=$request->name;
            $record->description=$request->description;
            $record->proyecto_id = $request->proyecto;
            $record->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('subproyecto')->withSuccess('Sub Proyecto : '.$request->name.' Registrado exitosamente');

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
        $record = SubProyecto::findOrFail($id);
        $proyectos= Proyecto::all();
        return \view('subproyecto.edit',\compact('record','proyectos'));
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

            $record = SubProyecto::findOrFail($id);
            $record->name=$request->name;
            $record->description= $request->description;
            $record->proyecto_id= $request->proyecto;
            $record->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }

        return \redirect('subproyecto')->withSuccess('Sub Proyecto : '.$request->name.' Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = SubProyecto::find($id);
        try {
            $record->delete();
            $success = true;
            $message = "Sub Proyecto eliminado exitosamente";
        } catch (QueryException $e) {
            $success = false;
            $message = "No se puede eliminar este sub proyecto, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con otros datos asociados.');
        }
        //Return response
        return \response()->json([
            'success'=>$success,
            'message'=>$message,
        ]);
        // return redirect('subproyecto')->withSuccess('Registro ha sido eliminado con exito!!');
    }
}
