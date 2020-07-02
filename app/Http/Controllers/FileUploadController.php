<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\IsJson;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Evaluado;
use App\Evaluador;

class FileUploadController extends Controller
{

    /**
     * Muesta el formulario para subir el archivo tipo json
     */
    public function index()
    {

        return view('fileUpload.index');

    }

    /**
     * Sube el archivo tipo json al servidor a la carpeta upload y luego redirecciona a una vista para validar
     * los datos recibidos en el archivo.
     */
    public function upload(Request $request)
    {

        request()->validate(
        [
            'fileName' => 'required',
            'fileName.*' => 'mimes:json|max:1024'
        ],
        [
            'fileName.required'=>'Debe seleccionar un archivo en formato JSON con los datos del Evaluado y sus Evaluadores..'
        ]);

        $fileOName= $request->fileName->getClientOriginalName();
        $fileName = date('YmdHis') . "." . $request->fileName-> getClientOriginalExtension();
        $pathFile = $request->fileName->storeAs('uploads', $fileName);
        if (Storage::exists($pathFile))
        {
            return \redirect()->route('json.validar',[$fileName,$fileOName]);
        }

        return redirect()->route('lanzar.index')
        ->with('danger','Archivo Json no fue subido exitosamente, intente nuevamente y corrija los datos incorrectos');

    }


    //Valida que el archivo subido exista en
    public function validar($fileName,$fileOName)
    {

         $pathFile = 'uploads/'.$fileName;
         if (Storage::exists($pathFile)){
            $json = Storage::disk('local')->get($pathFile);

            //Generamos un array
            $evaluadoArray=collect(json_decode($json));
            return \view('fileUpload.valida',compact('evaluadoArray','fileName','fileOName'));

         }
         \abort(404);

    }

    /**
     * Crea el registro del evaluado y los evaluadores relacionados
     * que realizaran la evaluacion
     */
    public function save(FileJson $fileJsonRequest,$fileName){


        $name=$fileJsonRequest->input('name.*');
        $relation=$fileJsonRequest->input('relation.*');
        $email=$fileJsonRequest->input('email.*');

        $pathFile = 'uploads/'.$fileName;

        if (Storage::exists($pathFile)){

            $json = Storage::disk('local')->get($pathFile);
            $evaluadoJson=collect(json_decode($json));

            $evaluado= new Evaluado();
            $evaluado->name=$evaluadoJson['Evaluado'];
            $evaluado->status=0;
            $evaluado->word_key=$fileName;
            $evaluado->save();

            for ($i=0; $i < count($name); $i++) {
                $evaluador= new Evaluador();
                $evaluador->name=$name[$i];
                $evaluador->email=$email[$i];
                $evaluador->relation=$relation[$i];
                $evaluador->remember_token= Str::random(32);
                $evaluador->status=0;
                $evaluado->evaluadores()->save($evaluador);
            }

        }else{
            \abort(404);
        }

        return redirect()->route('lanzar.index')
        ->withSuccess('Archivo JSON Procesado con exito!!. Ya estamos listo para lanzar una nueva Evaluacion, facilmente.');
    }
}
