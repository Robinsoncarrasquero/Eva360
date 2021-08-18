<?php

namespace App\Http\Controllers;

use App\FBstatu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FBstatuController extends Controller
{
    //
    public function index()
    {
        $fbstatus=FBstatu::simplePaginate(25);
        return \view('fbstatus.index',compact('fbstatus'));
    }

    /**
     * Show the form for creating a new fbstatus.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fbstatus.create');
    }

    /**
     * Store a newly created fbstatus in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $formrequest)
    {
        try {
            $fbstatus = new FBstatu();
            $fbstatus->name = $formrequest->name;
            $fbstatus->description = $formrequest->description;
            $fbstatus->save();
            } catch (QueryException $e) {
            return redirect()
            ->back()->withErrors('Error imposible Guardar este registro. El Nombre debe ser unico, no se permite duplicados.');
        }
        return \redirect('fbstatu')->withSuccess('Registro : '.$formrequest->name.' creado exitosamente');
    }

    /**
     * Show the form for editing the specified fbstatus.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($fbstatu)
    {
        $fbstatu = FBstatu::findOrFail($fbstatu);
        return \view('fbstatus.edit',\compact('fbstatu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $formrequest, $fbstatus)
    {
        $fbstatus = FBstatu::findOrFail($fbstatus);
        try {
            $fbstatus->name=$formrequest->name;
            $fbstatus->description=$formrequest->description;
            $fbstatus->save();
        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }
        return \redirect('fbstatu')->withSuccess('Registro : '.$formrequest->name.' actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($fbstatu)
    {
        $fbstatus = FBstatu::find($fbstatu);

        try {
            $fbstatus->delete();
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
