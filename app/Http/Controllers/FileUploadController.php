<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{

    /**
     * Mostrara el formulario para subir el archivo
     */
    public function index()
    {

        return view('fileUpload.index');


    }

    /**
     * Subira el archivo al servidor en la carpeta de files y redirecciona a una vista para validar
     * los datos recibidos en el archivo subido.
     */
    public function upload(Request $request)
    {

           request()->validate([
            'fileName' => 'required',
            'fileName.*' => 'mimes:json|max:1024'
           ]);

            $fileOriginalName= $request->fileName->getClientOriginalName();

            $fileName = date('YmdHis') . "." . $request->fileName-> getClientOriginalExtension();

            $pathFile = $request->fileName->storeAs('uploads', $fileName);

            //verificamos archivo subido existe
            if (Storage::exists($pathFile))
            {
                //Obtenemos el archivo Json
                $json = Storage::disk('local')->get($pathFile);

                //Generamos un array
                $evaluadoArray=collect(json_decode($json));
                //dd($evaluadoArray);
                return view('fileUpload.valida',compact('evaluadoArray','fileName','fileOriginalName'))
                ->with('success','Archivo subido exitosamente!!');

            }
            //si no se encuentra el archivo subido lanzamos un error 404.
            return back()
            ->with('danger','No pudo subirse el archivo al servidor, intente nuevamente.')
            ->with('file',$fileOriginalName);

    }

    /**
     * Presenta los datos recibidos en el archivo los valida y los salva el archivo en dos
     * archivos evaluado y evaluadores
     */
    public function save(Request $request){



    }

}
