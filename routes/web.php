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
* Resource de Proyecto
*
*/

Route::resource('proyecto', 'ProyectoController')
->middleware('role:admin');

Route::post('proyecto/delete/{id}','ProyectoController@destroy')->name('proyecto.delete');

/**
* Resource de Sub Proyecto
*
*/

Route::resource('subproyecto', 'SubProyectoController')
->middleware('role:admin');

Route::post('subproyecto/delete/{id}','SubProyectoController@destroy')->name('subproyecto.delete');


/**
* Resource de Nivel de cargo
*
*/
Route::resource('nivelCargo', 'NivelCargoController')->middleware('role:admin');
Route::post('nivelcargo/delete/{id}','NivelCargoController@destroy')->name('nivelcargo.delete');


/**
* Resource de Cargo
*
*/

Route::resource('cargo', 'CargoController')
->middleware('role:admin');

Route::post('cargo/delete/{id}','CargoController@destroy')->name('cargo.delete');

/**
* Resource de Departamento
*
*/

Route::resource('departamento', 'DepartamentoController')
->middleware('role:admin');

Route::post('departamento/delete/{id}','DepartamentoController@destroy')->name('departamento.delete');
/**
* Route de User
*
*/
Route::get('/user/list', 'UserController@index')->name('index');
Route::post('user/delete/{id}', 'UserController@destroy')->name('user.delete')->middleware('role:admin');
Route::resource('user', 'UserController')->middleware('role:admin');

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

Route::post('frecuencia/delete/{id}','FrecuenciaController@destroy')->name('frecuencia.delete');

/**
* Resource de Proyecto Panel de Evaluado
*
*/

Route::resource('proyectoevaluado', 'ProyectoPanelController')
->middleware('role:admin');

Route::get('proyectoevaluado/{subproyecto}/create', 'ProyectoPanelController@create')->name('proyectoevaluado.create')
->middleware('role:admin');

/**
* Resource de Evaluado
*
*/

Route::resource('evaluado', 'EvaluadoController')
->middleware('role:admin');

Route::post('evaluado/delete/{id}', 'EvaluadoController@destroy')->name('evaluado.delete');

Route::get('evaluado/subproyecto/{subproyecto}/create', 'EvaluadoController@create')->name('evaluado.create')
->middleware('role:admin');


/**Panel de Talent
 *
*/

Route::get('talent', 'TalentController@indexevaluado')->name('talent.index')
->middleware('role:admin');

Route::get('talent/historico/evaluaciones/{id}', 'TalentController@historicoevaluaciones')->name('talent.historicoevaluaciones')
->middleware('role:admin');

Route::get('talent/create/evaluado/{id}', 'TalentController@createevaluado')->name('talent.createevaluado')
->middleware('role:admin');

Route::post('talent/store/evaluado/{id}', 'TalentController@storeevaluado')->name('talent.storeevaluado')
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
 * Ajax Controller para manejo de funcionalidades con ajax
 */
//Envio de correo a evaluador para responder el cuestionario
Route::post('sendEmailEvaluador/{id}','AjaxController@sendEmailEvaluador')->name('ajaxsendemailevaluador')
->middleware('role:admin');

//Envio de correo a evaluador para responder el cuestionario
Route::post('changeEmailEvaluador','AjaxController@changeEmailEvaluador')->name('ajaxchangeemailevaluador')
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

Route::post('competencia/delete/{id}', 'CompetenciaController@destroy')->name('competencia.delete')
->middleware('role:admin');

Route::resource('tipo', 'TipoController')
->middleware('role:admin');

Route::get('tipo/edit/{id}', 'TipoController@edit')->name('tipo.edit')
->middleware('role:admin');

Route::post('tipo/delete/{id}', 'TipoController@destroy')->name('tipo.delete')
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
// Route::get('lanzar/modelo', "LanzarPruebaController@index")
// ->name('lanzar.modelo')
// ->middleware(['role:admin']);

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
 * Presenta una grafica de resultados personales por subproyecto
 */
Route::get('resultados/{subproyecto_id}/graficaresultadospersonales',"ResultadosController@graficaPersonales")
->name('resultados.graficaPersonales')
->middleware(['auth','role:admin']);

/**
 * Presenta una tabla de resultados personales tabulados por subproyecto
 */
Route::get('resultados/{subproyecto_id}/resultadospersonalestable',"ResultadosController@resultadosPersonalesTable")
->name('resultados.resultadospersonalestabulados')
->middleware(['auth','role:admin']);


/**
 * Presenta una tabla de analisis personales tabulados por subproyecto
 */
Route::get('resultados/{subproyecto_id}/analisispersonalestable',"ResultadosController@analisisPersonalesTable")
->name('resultados.analisispersonalestabulados')
->middleware(['auth','role:admin']);


/**
 * Presenta la grafica de competencias por tipo
 */
Route::get('resultados/{proyecto_id}/resultadosgeneralestipo',"ResultadosController@resultadosGeneralesTipo")
->name('resultados.resultadosgeneralestipo')
->middleware(['auth','role:admin']);

/**
 * Presenta la grafica de competencias por niveles de cargos
 */
Route::get('resultados/{proyecto_id}/resultadosgeneralesnivel',"ResultadosController@resultadosGeneralesNivel")
->name('resultados.resultadosgeneralesnivel')
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
