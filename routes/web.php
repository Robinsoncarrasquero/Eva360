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


Route::get('/emergencia', 'EmailController@emergency')->name('emergency');

Route::get('/contactar', 'EmailController@emailtest')->name('emailtest');

Route::post('/contactar', 'EmailController@contact')->name('contact');


Route::get('ajaxRequest', 'AjaxController@ajaxRequest');

Route::post('ajaxRequest', 'AjaxController@ajaxRequestPost')->name('ajaxRequest.post');

//Presentar la lista de evaluados para seleccionar
Route::get('lanzar', "LanzarPruebaController@index")
        ->name('lanzar.index');

        //Buscar un Evaluado por nombre
Route::get('lanzar/buscarpornombre', "LanzarPruebaController@burcarWordKey")
->name('lanzar.buscarwordkey');

//Seleccionar las competencias y evaluadores de la prueba paso1
Route::get('lanzar/{evaluado}/seleccionar',"LanzarPruebaController@seleccionar")
        ->name('lanzar.seleccionar')
        ->where('evaluado','[0-9]+');

//Confirmacion de los datos seleccionado en le paso 1
Route::get('lanzar/{evaluado}/confirmar',"LanzarPruebaController@confirmar")
->name('lanzar.confirmar')
->where('evaluado','[0-9]+');

//Lanzar la prueba creando los registros de la prueba y enviando los correso
Route::post('lanzar/{evaluado}',"LanzarPruebaController@procesar")
        ->name('lanzar.procesar');

