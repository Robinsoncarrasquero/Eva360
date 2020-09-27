<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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

/**
 * Route de presentacion del sistema
 *
 */
Route::get('/', function () {
    return view('vision360');
});


/**
* Route de User
*
*/
Route::get('/user/list', 'UserController@index')->name('index');
Route::resource('user', 'UserController');

/**
 * Autenticacion full
 *
 */
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/logout', 'HomeController@logout')->name('logout');

/**
 * Entrada al modulo de Vision 360
 *
 */
Route::get('vision360', 'HomeController@vision360')->name('vision360');

/**
* Resource de Frecuencia de la evaluacion
*
*/

Route::resource('frecuencia', 'FrecuenciaController')
->middleware('role:admin');

/**
* Resource de Evaluado
*
*/

Route::resource('evaluado', 'EvaluadoController')
->middleware('role:admin');

/**
 * Modelo de Prueba
 *
 */
Route::get('modelo', 'ModeloController@index')->name('modelo.index')
->middleware('role:admin');

Route::post('modelo/store', 'ModeloController@store')->name('modelo.store')
->middleware('role:admin');

Route::post('modelo/filtro', 'ModeloController@filtro')->name('modelo.filtro')
->middleware('role:admin');

Route::get('modelo/create', 'ModeloController@create')->name('modelo.create')
->middleware('role:admin');

Route::delete('modelo/destroy/{modelo}', 'ModeloController@destroy')->name('modelo.destroy')
->middleware('role:admin');

Route::get('modelo/{modelo}/show', 'ModeloController@show')->name('modelo.show')
->middleware('role:admin');

Route::get('ajaxmodeloajax/data', 'ModeloController@ajaxCompetencias')->name('modelo.ajaxcompetencias')
->middleware('role:admin');

/**
 * Resource de tipo de competencia
 *
 * */
Route::resource('grupocompetencia', 'GrupoCompetenciaController')
->middleware('role:admin');

/**
 * Resource de tipo de competencia
 *
 * */

Route::resource('competencia', 'CompetenciaController')
->middleware('role:admin');

Route::resource('tipo', 'TipoController')
->middleware('role:admin');

/**
 * Route test error abort
 *
 */

Route::get('/error', function () {
    return abort(500);
});

/**
 * Route de Lanzar prueba sin modelo
 */

/**
 * Presentar la lista de evaluados para seleccionar
 *
 */
Route::get('lanzar', "LanzarPruebaController@index")
->name('lanzar.index')
->middleware(['role:admin']);

/**
 * Seleccionar las competencias y evaluadores de la prueba paso1
 *
 */

Route::get('lanzar/{evaluado}/seleccionarcompetencias',"LanzarPruebaController@seleccionar")
->name('lanzar.seleccionar')
->where('evaluado','[0-9]+')
->middleware(['role:admin']);

/**
 * Confirmacion de las competencias seleecionadas
 *
 *  */
Route::post('lanzar/{evaluado}/confirmar',"LanzarPruebaController@confirmar")
->name('lanzar.confirmar')
->where('evaluado','[0-9]+')
->middleware(['role:admin']);

/**
 * Lanzar la prueba creando los registros de la prueba y enviando los correos
 *
*/
Route::post('lanzar/{evaluado}',"LanzarPruebaController@procesar")
->name('lanzar.procesar')
->middleware(['role:admin']);

/**
 * Route de Lanzar Modelos
 *
*/

/**
 * Lista de candidatos para la prueba desde un modelo
 *
*/
Route::get('lanzar/modelo', "LanzarPruebaController@index")
->name('lanzar.modelo')
->middleware(['role:admin']);

/**
 * Seleccion del modelo
 *
 * */
Route::get('lanzar/{evaluado}/seleccionarmodelo', "LanzarModeloController@seleccionarmodelo")
->name('lanzar.seleccionarmodelo')
->middleware(['role:admin']);

/**
 * Lanzar el modelo procesando las competencias asociadas
*/
Route::post('lanzar/{evaluado}/procesarmodelo', "LanzarModeloController@procesarmodelo")
->name('lanzar.procesarmodelo')
->middleware(['role:admin']);

/**
 * Route de evaluaciones
*/

/**
 * Evaluador con logueo con token a la prueba
*/
Route::get('evaluacion/{token}/evaluacion',"EvaluacionController@token")
->name('evaluacion.token');

/**
 * Presenta las competencias al evaluador
*/
Route::get('competencias/{evaluador}/evaluacion',"EvaluacionController@competencias")
->name('evaluacion.competencias');

/**
 * Pregunta de la prueba
*/
Route::get('evaluacionget/{competencia}/preguntas',"EvaluacionController@responder")
->name('evaluacion.responder')
->where('evaluador','[0-9]+')
->middleware(['auth']);

/**
 * Evaluador Responde la pregunta
*/
Route::post('evaluacionpost/{competencia}/respuesta',"EvaluacionController@store")
->name('evaluacion.store')
->where('evaluador','[0-9]+')
->middleware(['auth']);

/**
 * Evaluador finaliza la prueba
*/
Route::post('evaluacion/{evaluador}/finalizar',"EvaluacionController@finalizar")
->name('evaluacion.finalizar')
->middleware(['auth']);

/**
 * Lista de evaluados del Evaluador
*/
Route::get('evaluacion',"EvaluacionController@index")
->name('evaluacion.index')
->middleware(['auth']);


/**
* Resultados de las pruebas
*/
Route::get('resultados/{evaluado_id}/evaluacion',"ResultadosController@resultados")
->name('resultados.evaluacion')
->middleware(['auth','role:admin']);

Route::get('resultados/{evaluado_id}/finales',"ResultadosController@resumidos")
->name('resultados.finales')
->middleware(['auth','role:admin']);

/**
 * Presenta una grafica con resultados 360
 */
Route::get('resultados/{evaluado_id}/graficas',"ResultadosController@graficas")
->name('resultados.graficas')
->middleware(['auth','role:admin']);

/**
 * Presenta una grafica con resultados individuales por grupo
 */
Route::get('resultados/{evaluado_id}/graficaindividual',"ResultadosController@graficaIndividual")
->name('resultados.graficaindividual')
->middleware(['auth','role:admin']);


/**
 * Route upload file json
 *
*/

/**
 * Formulario para Subir archivo json
 *
*/
Route::get('file-upload', 'FileUploadController@index')
->name('json.fileindex')
->middleware(['auth','role:admin']);

/**
 * Subir el archivo seleccionado
 * */
Route::post('file-upload', 'FileUploadController@upload')
->name('json.fileupload')
->middleware(['auth','role:admin']);

/**
 * Formulario con los datos del evaluado y los evaluadores
 * subidos en el archivo json
 */

Route::get('filevalida/{filename}/{fileOname}/valida',"FileUploadController@validar")
->name('json.validar')
->middleware(['auth','role:admin']);

/**
 *  Salvar los datos del evaluado y evaluadores en el sistema
 */

Route::post('file-save/{data}/jsonsave','FileUploadController@save')
->name('json.filesave')
->middleware(['auth','role:admin']);

/**
 * Permite la descarga del archivo en formato json establecido para subir datos
 *
 */
Route::get('uploads', function () {
    if (Storage::exists("config/eva360.json")){
        return Storage::response("config/eva360.json");
    }
    abort(404);
})->where([
    'file' => '(.*?)\.(json|jpg|png|jpeg|gif)$'
])
->middleware(['auth']);


/**
 * Routes test upload
 *
 */
Route::post('file', function (Request $request,$fileName) {
    $pathFile = $request->fileName->storeAs('uploads', $fileName);
    if (Storage::exists("uploads/$fileName")){
        return Storage::response("uploads/$fileName");
    }
    abort(404);
})->where([
    'file' => '(.*?)\.(json|jpg|png|jpeg|gif)$'
])->name('jsonfile');
