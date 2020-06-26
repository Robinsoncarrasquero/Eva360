<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

    Route::get('file-upload', 'FileUploadController@index')->name('evaluado.fileindex');

    Route::post('file-upload', 'FileUploadController@upload')->name('evaluado.fileupload');


    Route::post('file-save/{data}', 'FileUploadController@save')->name('evaluado.filesave');

    Route::get('storagestorage/{archivo}', function ($archivo) {
        $public_path = public_path();
        $url = $public_path.'/storage/'.$archivo;
        //verificamos si el archivo existe y lo retornamos
        return $url;

        if (Storage::exists($archivo))
        {
          return response()->download($url);
        }
        //si no se encuentra lanzamos un error 404.
        abort(404);

   });


    //How to delete multiple row with checkbox using Ajax
    Route::get('category', 'CategoryController@index');

    //Route::delete('category/{id}', ['as'=>'category.destroy','uses'=>'CategoryController@destroy']);

    Route::delete('category/{id}', 'CategoryController@destroy')->name('category.destroy');

    Route::put('category/{id}', 'CategoryController@update')->name('category.update');

    Route::delete('delete-multiple-category', ['as'=>'category.multiple-delete','uses'=>'CategoryController@deleteMultiple']);

