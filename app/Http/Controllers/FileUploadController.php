<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\IsJson;
use Illuminate\Support\Str;
use App\Evaluado;
use App\Evaluador;

use Opis\JsonSchema\Validator;
use Opis\JsonSchema\ValidationResult;
use Opis\JsonSchema\ValidationError;
use Opis\JsonSchema\Schema;


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
     * Sube el archivo tipo json al servidor en la carpeta upload y luego redirecciona a una vista para validar
     * los datos recibidos en el archivo.
     */
    public function upload(Request $request)
    {

        request()->validate(
        [
            'fileName' => 'required|file|max:1',
            'fileName.*' => 'mimes:json|max:1',
        ],
        [
            'fileName.required'=>'Debe seleccionar un archivo en formato JSON segun el formato definido.',
            'fileName.max' => "El Maximo permitido para subir un archivo es un 1kb con un maximo de 10 evaluadores."
        ]);

        $fileOName= $request->fileName->getClientOriginalName();
        $fileName = date('YmdHis') . "." . $request->fileName-> getClientOriginalExtension();
        $pathFile = $request->fileName->storeAs('uploads', $fileName);

        $mensaje=$this->validaJsonSchema($pathFile);

        if (Storage::exists($pathFile) && $mensaje["validjson"])
        {
            return \redirect()->route('json.validar',[$fileName,$fileOName]);
        }
        return redirect()->route('json.fileindex')
        ->with('danger','Error ' .$mensaje["msg"]. ' Haga las correcciones e intente nuevamente ');
    }

    /**Validar el esquema del archivo Json */
    private function validaJsonSchema($pathFile){

        $pathFile=$pathFile;
        $pathSchema='config/my-schema.json';
        //$pathSchema='config/schema_other.json';
        $data = json_decode(Storage::get($pathFile));
        $schema = Schema::fromJsonString(Storage::get($pathSchema));
        $validator = new Validator();
        /** @var ValidationResult $result */
        $jsonresult = $validator->schemaValidation($data, $schema);

        if ($jsonresult->isValid()) {
            return ["validjson"=>true,"msg"=>"Data is valid"];
        } else {
            /** @var ValidationError $error */
            $error = $jsonresult->getFirstError();
            dd($jsonresult);
            // echo '$data is invalid', PHP_EOL;
            // echo "Error: ", $error->keyword(), PHP_EOL;
            // echo json_encode($error->keywordArgs(), JSON_PRETTY_PRINT), PHP_EOL;
            return ["validjson"=>false,"msg"=>"JSON does not validate."];

        }
    }

    //Valida que el archivo subido al servidor exista
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
