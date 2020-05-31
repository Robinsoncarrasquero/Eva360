<?php

use Illuminate\Support\Facades\Route;

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

Route::get('ajaxRequest', 'AjaxController@ajaxRequest');

Route::post('ajaxRequest', 'AjaxController@ajaxRequestPost')->name('ajaxRequest.post');

//Mostramos la lista de evaluados para seleccionar
Route::get('evaluado', "EvaluadoController@index")
        ->name('evaluado.index');


//Lanzamos la prueba para seleccionar los evaluadores y las preguntas
Route::get('evaluado/{evaluado}/lanzar',"EvaluadoController@edit")
        ->name('evaluado.lanzar')
        ->where('evaluado','[0-9]+');

//Update para marcar el chk de los evaluuadores y las preguntas
Route::post('evaluado/{evaluado}',"EvaluadoController@update")
        ->name('evaluado.update');

