<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\NivelCargo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records=Cargo::simplePaginate(10);
        return \view('cargo.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nivel_cargos =NivelCargo::all();

        return view('cargo.create',\compact("nivel_cargos"));
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
            $record = new Cargo();
            $record->name=$request->name;
            $record->description=$request->description;
            $record->nivel_cargo_id = $request->nivel;
            $record->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('cargo')->withSuccess('Cargo : '.$request->name.' Registrado exitosamente');

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
        $record = Cargo::findOrFail($id);
        $nivel_cargos = NivelCargo::all();
        return \view('cargo.edit',\compact('record','nivel_cargos'));
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

            $record = Cargo::findOrFail($id);
            $record->name=$request->name;
            $record->description= $request->description;
            $record->nivel_cargo_id= $request->nivel;
            $record->save();

        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }

        return \redirect('cargo')->withSuccess('Cargo : '.$request->name.' Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Cargo::find($id);
        try {
            $record->delete();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible Eliminar este registro, tiene restricciones con otros datos asociados.');
        }
        return redirect('cargo')->withSuccess('Registro ha sido eliminado con exito!!');
    }
}
