<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;

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
    return view('vision360');
});


/**Route de User */
Route::get('/user/list', 'UserController@index')->name('index');
Route::resource('user', 'UserController');

/**Autenticacion full */
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/logout', 'HomeController@logout')->name('logout');

/** Entrada al modulo de Vision 360 */
Route::get('vision360', 'HomeController@vision360')->name('vision360');
/**
 * Resource de Frecuencia de la evaluacion
 *
 */

Route::resource('frecuencia', 'FrecuenciaController')
->middleware('role:admin');


/**
 * Resource de Evaluado para ingresar manualmente un Evaluado con sus evaluadores
 *
 */

Route::resource('evaluado', 'EvaluadoController')
->middleware('role:admin');

/**
 * Resource de tipo de competencia
 *
 */
Route::resource('competencia', 'CompetenciaController')
->middleware('role:admin');

/**Resource de tipo de competencia */
Route::resource('tipo', 'TipoController')
->middleware('role:admin');

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
        ->name('lanzar.index')
        ->middleware(['role:admin']);


//Seleccionar las competencias y evaluadores de la prueba paso1
Route::get('lanzar/{evaluado}/seleccionar',"LanzarPruebaController@seleccionar")
        ->name('lanzar.seleccionar')
        ->where('evaluado','[0-9]+')
        ->middleware(['role:admin']);


//Confirmacion de los datos seleccionado en le paso 1
Route::post('lanzar/{evaluado}/confirmar',"LanzarPruebaController@confirmar")
->name('lanzar.confirmar')
->where('evaluado','[0-9]+')
->middleware(['role:admin']);


//Lanzar la prueba creando los registros de la prueba y enviando los correso
Route::post('lanzar/{evaluado}',"LanzarPruebaController@procesar")
        ->name('lanzar.procesar')
        ->middleware(['role:admin']);

/**
 *Route de evaluaciones
 */
//Evaluador entra por el token y loguea
Route::get('evaluacion/{token}/evaluacion',"EvaluacionController@token")
        ->name('evaluacion.token');

//Evaluador Responder las prueba
Route::get('competencias/{evaluador}/evaluacion',"EvaluacionController@competencias")
        ->name('evaluacion.competencias');


Route::get('evaluacionget/{competencia}/preguntas',"EvaluacionController@responder")
->name('evaluacion.responder')
->where('evaluador','[0-9]+')
->middleware(['auth']);


Route::post('evaluacionpost/{competencia}/respuesta',"EvaluacionController@store")
->name('evaluacion.store')
->where('evaluador','[0-9]+')
->middleware(['auth']);


/*
*Evaluador finaliza la prueba
*/
Route::post('evaluacion/{evaluador}/finalizar',"EvaluacionController@finalizar")
->name('evaluacion.finalizar');
//->middleware(['auth']);


/*
 * Lista de evaluados del Evaluador
 */
Route::get('evaluacion',"EvaluacionController@index")
        ->name('evaluacion.index');
        //->middleware(['auth']);


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
->name('resultados.evaluacion')
->middleware(['auth','role:admin']);


Route::get('resultados/{evaluado_id}/finales',"ResultadosController@resumidos")
->name('resultados.finales')
->middleware(['auth','role:admin']);


Route::get('resultados/{evaluado_id}/graficas',"ResultadosController@graficas")
->name('resultados.graficas')
->middleware(['auth','role:admin']);



    /**
     *Subir los archivo con los datos del evaluado y los evaluadores
     */

    Route::get('file-upload', 'FileUploadController@index')
    ->name('json.fileindex')
    ->middleware(['auth','role:admin']);

    Route::post('file-upload', 'FileUploadController@upload')
    ->name('json.fileupload')
    ->middleware(['auth','role:admin']);


    Route::get('filevalida/{filename}/{fileOname}/valida',"FileUploadController@validar")
    ->name('json.validar')
    ->middleware(['auth','role:admin']);


    Route::post('file-save/{data}/jsonsave','FileUploadController@save')
    ->name('json.filesave')
    ->middleware(['auth','role:admin']);


    Route::get('uploads', function () {
        if (Storage::exists("config/eva360.json")){
            return Storage::response("config/eva360.json");
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

