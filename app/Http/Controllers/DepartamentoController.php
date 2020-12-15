<?php

namespace App\Http\Controllers;

use App\Departamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $records=Departamento::simplePaginate(10);
        return \view('departamento.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departamento.create');
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
            $record = new  Departamento();
            $record->name=$request->name;
            $record->description=$request->description;
            $record->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('departamento')->withSuccess('Departamento : '.$request->name.' Registrado exitosamente');

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
        $record = Departamento::findOrFail($id);
        return \view('departamento.edit',\compact('record'));
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

            $record = Departamento::findOrFail($id);
            $record->name=$request->name;
            $record->description= $request->description;
            $record->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }

        return \redirect('departamento')->withSuccess('Departamento : '.$request->name.' Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Departamento::find($id);
        try {
            $record->delete();
            $success = true;
            $message = "Departamento eliminado exitosamente";
        } catch (QueryException $e) {
            $success = false;
            $message = "No se puede eliminar este departamento, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con otros datos asociados.');
        }
        //Return response
        return \response()->json([
            'success'=>$success,
            'message'=>$message,
        ]);
        // return redirect('departamento')->withSuccess('Registro ha sido eliminado con exito!!');
    }
}
