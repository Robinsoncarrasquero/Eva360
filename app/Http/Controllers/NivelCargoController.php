<?php

namespace App\Http\Controllers;

use App\NivelCargo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class NivelCargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=NivelCargo::all();
        return \view('nivelCargo.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nivelCargo.create');
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
            $record = new NivelCargo();
            $record->name=$request->name;
            $record->description=$request->description;
            $record->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('nivelCargo')->withSuccess('Nivel de Cargo : '.$request->name.' Registrado exitosamente');

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
        $record = NivelCargo::findOrFail($id);
        return \view('nivelCargo.edit',\compact('record'));
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

            $record = NivelCargo::findOrFail($id);
            $record->name=$request->name;
            $record->description= $request->description;
            $record->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }

        return \redirect('nivelCargo')->withSuccess('Nivel de Cargo : '.$request->name.' Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = NivelCargo::find($id);
        try {
            $record->delete();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Eliminar este registro, tiene restricciones con otros datos asociados.');
        }
        return redirect('nivelCargo')->withSuccess('Registro ha sido eliminado con exito!!');
    }
}
