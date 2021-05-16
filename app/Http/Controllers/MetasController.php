<?php

namespace App\Http\Controllers;

use App\Meta;
use App\SubMeta;
use App\Http\Requests\MetaCreateRequest;
use App\Tipo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MetasController extends Controller
{
    //
    /**
     * Display a listing of the metas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $metas=Meta::simplePaginate(5);
        return \view('metas.index',compact('metas'));

    }

    /**
     * Show the form for creating a new meta.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //Buscamos el json configurado con la tabla de submeta
        $jsonfile = Storage::disk('local')->get('config/submetas.json');

        //Convertimos en una array
        $submetas=collect(json_decode($jsonfile));
        $tipos = Tipo::all();

        return view('metas.create',compact('submetas','tipos'));
    }

    /**
     * Store a newly created meta in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MetaCreateRequest  $formrequest)
    {
        try {
            $meta = new Meta();
            $meta->name=$formrequest->name;
            $meta->description=$formrequest->description;
            $meta->nivelrequerido = $formrequest->nivelrequerido;
            $meta->tipo_id = $formrequest->tipo;
            $meta->save();
         } catch (QueryException $e) {
            //Alert::error('meta',Arr::random(['duplicada','Repetida']));
            return redirect()
            ->back()->withErrors('Error imposible Guardar este registro. El Nombre de la meta debe ser unico, no se permite duplicados.');
        }

        //Creamos los submetas con las preguntas
        $gName=$formrequest->input('submetaName.*');
        $submetaDescripcion=$formrequest->input('submetaDescription.*');
        $submetaRequerido=$formrequest->input('submetaRequerido.*');

        for ($i=0; $i < count($gName); $i++) {
            $submeta= new SubMeta();
            $submeta->submeta=$gName[$i];
            $submeta->description=$submetaDescripcion[$i];
            $submeta->requerido=$submetaRequerido[$i];
            $meta->submetas()->save($submeta);
        }
        //Alert::success('meta '.$formrequest->name,Arr::random(['Registrada exitosamente','Registro Exitoso']));
        return \redirect('meta')->withSuccess('Meta creada exitosamente : '.$formrequest->name.' Registrado exitosamente');
    }

    /**
     * Show the form for editing the specified meta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($meta)
    {
        $meta = Meta::findOrFail($meta);
        $tipos = Tipo::all();

        return \view('metas.edit',\compact('meta','tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MetaCreateRequest $formrequest, $meta)
    {

        $meta = Meta::findOrFail($meta);

        try {
            $meta->name=$formrequest->name;
            $meta->description=$formrequest->description;
            $meta->nivelrequerido = $formrequest->nivelrequerido;
            $meta->tipo_id = $formrequest->tipo;
            $meta->save();

            //Creamos las submetas de la meta
            $submetaDescripcion=$formrequest->input('submetaDescription.*');
            $submetaRequerido=$formrequest->input('submetaRequerido.*');
            $submetaid=$formrequest->input('submetaid');

            for ($i=0; $i < count($submetaid); $i++) {
                $submeta= SubMeta::find($submetaid[$i]);
                $submeta->description=$submetaDescripcion[$i];
                $submeta->requerido=$submetaRequerido[$i];
                $submeta->save();
            }

        } catch (QueryException $e) {
            Alert::error('Meta '.$formrequest->name,Arr::random(['Duplicada','Registro ya existe']));

            return redirect()->back()
            ->withErrors('Error imposible guardar este registro. Revise los datos del formulario e intente nuevamante.');
        }
        Alert::success('Meta '.$formrequest->name,Arr::random(['Bien','Excelente']));

        return \redirect('meta')->withSuccess('Meta : '.$formrequest->name.' Actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($meta)
    {
        $meta = Meta::find($meta);
        try {
            $meta->delete();
            $success = true;
            $message = "meta eliminada exitosamente";
        } catch (QueryException $e) {
            $success = false;
      	    $message = "No se puede eliminar esta meta, data restringida";
            // return redirect()->back()
            // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas evaluaciones realizadas.');
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

        // return redirect('meta')->withSuccess('La meta ha sido eliminada con exito!!');
    }
}
