<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;


    //Validar Email
    // Route::post('check', function (Request $request) {
    //     $request->validate([
    //         'email' => function ($attribute, $value, $fail) {
    //         if ( !(new EmailValidator())->isValid($value, new DNSCheckValidation()) ) {
    //             $fail(trans('validation.check_email_dns',[$attribute]));
    //         }
    //     },]);
    //     return response()->json(['ok' => 'it´s ok']);
    // });

    Route::post('check', function (Request $request) {
        $request->validate([
            'email' => 'foo',
        ]);
        return response()->json(['ok' =>'ok' ]);
    });


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

/**
 * Resource de competencias
 *
 */
Route::resource('competencia', 'CompetenciaController');


/**Resource de tipo de competencia */
Route::resource('tipo', 'TipoController');

Route::get('chart', 'ChartController@index');

Route::get('/error', function () {
    return abort(500);
});

Route::get('/emergencia', 'EmailController@emergency')->name('emergency');

Route::get('/contactar', 'EmailController@emailtest')->name('emailtest');

Route::post('/contactar', 'EmailController@contact')->name('contact');


Route::get('ajaxRequest', 'AjaxController@ajaxRequest');

Route::post('ajaxRequest', 'AjaxController@ajaxRequestPost')->name('ajaxRequest.post');

//Presentar la lista de evaluados para seleccionar
Route::get('lanzar', "LanzarPruebaController@index")
        ->name('lanzar.index');


//Seleccionar las competencias y evaluadores de la prueba paso1
Route::get('lanzar/{evaluado}/seleccionar',"LanzarPruebaController@seleccionar")
        ->name('lanzar.seleccionar')
        ->where('evaluado','[0-9]+');

//Confirmacion de los datos seleccionado en le paso 1
Route::post('lanzar/{evaluado}/confirmar',"LanzarPruebaController@confirmar")
->name('lanzar.confirmar')
->where('evaluado','[0-9]+');

//Lanzar la prueba creando los registros de la prueba y enviando los correso
Route::post('lanzar/{evaluado}',"LanzarPruebaController@procesar")
        ->name('lanzar.procesar');


/**
 *Route de evaluaciones
 */
//Evaluador Responder las prueba
Route::get('evaluacion/{token}/evaluacion',"EvaluacionController@competencias")
        ->name('evaluacion.competencias');

Route::get('evaluacionget/{competencia}/preguntas',"EvaluacionController@responder")
->name('evaluacion.responder')
->where('evaluador','[0-9]+');

Route::post('evaluacionpost/{competencia}/respuesta',"EvaluacionController@store")
->name('evaluacion.store')
->where('evaluador','[0-9]+');

/*
*Evaluador finaliza la prueba
*/
Route::post('evaluacion/{evaluador}/finalizar',"EvaluacionController@finalizar")
->name('evaluacion.finalizar');

/*
 * Lista de evaluados del Evaluador
 */
Route::get('evaluacion/{token}/index',"EvaluacionController@index")
        ->name('evaluacion.index');

/**
 * ajax prueba
 */
    //Presentar la lista de evaluados para seleccionar
    Route::get('ajaxlanzar', "AjaxLanzarPruebaController@index")
            ->name('ajaxlanzar.index');

    //Seleccionar las competencias y evaluadores de la prueba paso1
    Route::get('ajaxlanzar/{evaluado}/seleccionar',"AjaxLanzarPruebaController@seleccionar")
            ->name('ajaxlanzar.seleccionar')
            ->where('evaluado','[0-9]+');

    //Seleccionar las competencias y evaluadores de la prueba paso1
    Route::post('ajaxlanzar/filtrar',"AjaxLanzarPruebaController@filtrar")
    ->name('ajaxlanzar.filtrar');


    /*
     *Resultados de las pruebas
    */
    Route::get('resultados/{evaluado_id}/evaluacion',"ResultadosController@resultados")
    ->name('resultados.evaluacion');

    Route::get('resultados/{evaluado_id}/finales',"ResultadosController@resumidos")
    ->name('resultados.finales');

    Route::get('resultados/{evaluado_id}/graficas',"ResultadosController@graficas")
    ->name('resultados.graficas');



    /**
     *Subir los archivo con los datos del evaluado y los evaluadores
     */

    Route::get('file-upload', 'FileUploadController@index')->name('json.fileindex');


    Route::post('file-upload', 'FileUploadController@upload')->name('json.fileupload');

    Route::get('filevalida/{filename}/{fileOname}/valida',"FileUploadController@validar")
        ->name('json.validar');

    Route::post('file-save/{data}/jsonsave','FileUploadController@save')->name('json.filesave');

    Route::get('uploads', function () {
        if (Storage::exists("uploads/eva360.json")){
            return Storage::response("uploads/eva360.json");
        }
         //si no se encuentra lanzamos un error 404.
         abort(404);

    })->where([
        'file' => '(.*?)\.(json|jpg|png|jpeg|gif)$'
    ]);

    Route::post('file', function (Request $request,$fileName) {

        $pathFile = $request->fileName->storeAs('uploads', $fileName);

        if (Storage::exists("uploads/$fileName")){
            return Storage::response("uploads/$fileName");
        }
         //si no se encuentra lanzamos un error 404.
         abort(404);

    })->where([
        'file' => '(.*?)\.(json|jpg|png|jpeg|gif)$'
    ])->name('jsonfile');


    //How to delete multiple row with checkbox using Ajax
    Route::get('category', 'CategoryController@index');

    //Route::delete('category/{id}', ['as'=>'category.destroy','uses'=>'CategoryController@destroy']);

    Route::delete('category/{id}', 'CategoryController@destroy')->name('category.destroy');

    Route::put('category/{id}', 'CategoryController@update')->name('category.update');

    Route::delete('delete-multiple-category', ['as'=>'category.multiple-delete','uses'=>'CategoryController@deleteMultiple']);

