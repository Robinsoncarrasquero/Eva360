<?php

use App\Competencia;
use App\Evaluador;
use App\Frecuencia;
use App\Notifications\EvaluacionPendiente;
use App\Notifications\Nexmosms;
use App\Notifications\TareaPendienteDeEvaluacion;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Nexmo\Laravel\Facade\Nexmo;


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
 * Route simulador de Autoevaluacion
 */


Route::get('simuladorfeedback/{id}/edit', 'SimuladorController@feedbackedit')->name('simulador.feedback.edit');
// ->middleware('role:user');

Route::post('simuladorfeedback/update/{id}', 'SimuladorController@feedbackupdate')->name('simulador.feedback.update');

 /**
 * Presenta una grafica de resultados personales por subproyecto
 */
Route::get('simulador/{subproyecto_id}/charpersonalporgrupo',"SimuladorController@charpersonalporgrupo")
->name('simulador.charpersonalporgrupo')
->middleware(['auth']);

/**
 * Presenta una tabla de analisis personales tabulados por subproyecto
 */
/**
 * Presenta una tabla de analisis personales tabulados por subproyecto
 */
Route::get('simulador/{token}/tokenresultado',"SimuladorController@tokenresultado")
->name('simulador.tokenresultado');

Route::get('simulador/{subproyecto_id}/cumplimiento',"SimuladorController@analisiscumplimiento")
->name('simulador.analisiscumplimiento')
->middleware(['auth']);

Route::get('simulador/{token}/evaluacion',"SimuladorController@token")
->name('simulador.token');

Route::get('simulador/{evaluador}/simulador',"SimuladorController@competencias")
->name('simulador.competencias')->middleware(['auth']);

Route::get('simulador/autoevaluacion',"SimuladorController@autoevaluacion")
->name('simulador.autoevaluacion');

Route::get('simulador/{competencia}/responder',"SimuladorController@responder")
    ->name('simulador.responder')
    ->where('evaluador','[0-9]+')
    ->middleware(['auth']);
 /**
     * Evaluador Responde la pregunta
    */
    Route::post('simuladorstore/{competencia}/respuesta',"SimuladorController@store")
    ->name('simulador.store')
    ->where('evaluador','[0-9]+')
    ->middleware(['auth']);

    /**
     * Evaluador finaliza la prueba
    */
    Route::post('simuladorfinaliza/{evaluador}/finalizar',"SimuladorController@finalizar")
    ->name('simulador.finalizar')
    ->middleware(['auth']);

    /**
     * Lista de evaluados del Evaluador
    */
    Route::get('simuladorindex',"SimuladorController@index")
    ->name('simulador.index')
    ->middleware(['auth']);

     /**
     * Simulador historico del Evaluado
    */
    Route::get('simuladorhistorico',"SimuladorController@historicoevaluaciones")
    ->name('simulador.historicoevaluaciones')
    ->middleware(['auth']);

Route::post('simulador/registrar',"SimuladorController@registrar")
->name('simulador.registrar');

Route::get('simulador/ajaxmodeloajax', 'SimuladorController@ajaxCompetencias')->name('simulador.ajaxcompetencias');

Route::get('simulador/{evaluado_id}/resultados',"SimuladorController@resultados")
->name('simulador.resultados');

Route::get('simulador/{evaluado_id}/finales',"SimuladorController@finales")
->name('simulador.finales');

/**
 * Presenta una grafica con resultados 360
 */
Route::get('simulador/{evaluado_id}/charindividual',"SimuladorController@charindividual")
->name('simulador.charindividual');

/**Tareas de notificaciones */
Route::get('/tareapendiente/{evaluador}',function ($evaluador)
{
    if ($evaluador){
        $receptores = Evaluador::where('id',$evaluador->id)->get();
    }else{
        //$receptores = Evaluador::where('status',1)->get();
        $receptores = Evaluador::where('status',1)->where('virtual',false)->get();
    }
    $delay = now()->addSeconds(1);

    // foreach ($receptores as $receptor) {
    //     $receptor->notify((new EvaluacionPendiente('evaluacion.token'))->delay($delay));
    // }
    Notification::send($receptores, new TareaPendienteDeEvaluacion('evaluacion.token'));

})->where('id', '[0-9]+')->name('tareapendiente');

Route::middleware(['auth', 'role:admin'])->group( function() {
    Route::post('/paypal/pay', 'PaymentController@payWithPayPal')->name('paypal.makepay');
    Route::get('/paypal/status', 'PaymentController@payPalStatus')->name('paypal.status');
    Route::get('/paypal/transactions', 'PaymentController@transactions')->name('paypal.transactions');
    Route::get('/paypal/editpay', 'PaymentController@editPayPayPal')->name('paypal.editPayPayPal');
});

/**
 * Route de presentacion competencias publicas
 *
 */
Route::get('/', function () {
    $competencias = Competencia::all();
    return view('vision360',compact('competencias'));
})->name('vision360');

/**
 * Mostrar una competencia seleccionada desde la competencias publicas
 */
Route::get('/diccionariodecompetencias/{id}/competencia', function ($id) {

    $competencia = Competencia::find($id);
    $frecuencias = Frecuencia::all();
    return view('vision360ver',compact('competencia','frecuencias'));
})->name('verdiccionariodecompetencia');

/**
 * Configuracion del sistema
 */
Route::middleware(['auth', 'role:admin'])->group( function() {
    Route::get('configuracion/config',"ConfiguracionController@edit")
    ->name('configuracion.edit');

    Route::post('configuracion/update',"ConfiguracionController@update")
    ->name('configuracion.update');
});
/**
 * Route de plantilla de organigrama fija
 */
Route::get('/organigrama', function () {
    return view('plantillas.organigrama');
});

Route::get('/verorganigrama', function () {
    return view('plantillas.organigrama')->name('plantillas.ver');
});

/**
 * Route de evaluaciones de objetivos competencias duras
*/

/**
 * Evaluador con logueo con token a la prueba
*/
Route::group(['middleware' => 'auth'], function() {

    Route::get('objetivos/{token}/evaluacion',"ObjetivosController@token")
    ->name('objetivo.token');

    /**
     * Presenta las competencias por objetivos al evaluador
    */
    Route::get('competenciasporobjetivos/{evaluador}/objetivos',"ObjetivosController@metas")
    ->name('objetivo.metas');

    /**
     * Pregunta de la prueba
    */
    Route::get('objetivoget/{competencia}/responder',"ObjetivosController@responder")
    ->name('objetivo.responder');

    /**
     * Evaluador Responde la pregunta
    */
    Route::post('objetivopost/{competencia}/respuesta',"ObjetivosController@store")
    ->name('objetivo.store');

    /**
     * Evaluador finaliza la prueba
    */
    Route::post('objetivo/{evaluador}/finalizar',"ObjetivosController@finalizar")
    ->name('objetivo.finalizar');


    /**
     * Lista de evaluaciones del Evaluador
    */
    Route::get('objetivo',"ObjetivosController@index")
    ->name('objetivo.index');


    /**
     * Presenta el evaluador con las competencias a evaluar
    */
    Route::get('objetivoevaluadores/{evaluado}/evaluadores',"ObjetivosController@evaluacion")
    ->name('objetivo.evaluacion');

 /**
  * Presenta los resultados de la evaluacion por objetivos
   */
    Route::get('objetivoresultado/{evaluado}/resultado',"ObjetivosController@resultado")
    ->name('objetivo.resultado');

    /**
 * Presenta una grafica de linea con los resultados de la evaluacion por objetivos
 */
Route::get('objetivografica/{evaluado_id}/charindividual',"ObjetivosController@charindividual")
->name('objetivo.charindividual')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

/**
 * Presenta una grafica de resultados personales por subproyecto
 */
Route::get('objetivosporsubproyecto/{subproyecto_id}/charpersonalporgrupo',"ObjetivosController@charpersonalporgrupo")
->name('objetivo.charpersonalporgrupo')
->middleware(['auth']);


/**
 * Presenta una tabla de analisis personales tabulados por subproyecto
 */
Route::get('objetivoscumplimiento/{subproyecto_id}/cumplimiento',"ObjetivosController@analisiscumplimiento")
->name('objetivo.analisiscumplimiento')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

/**
 * Presenta la grafica de competencias por tipo
 */
Route::get('objetivosresultadosportipo/{proyecto_id}/resultadosgeneralestipo',"ObjetivosController@resultadosGeneralesTipo")
->name('objetivo.resultadosgeneralestipo')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);
/**
 * Presenta la grafica de competencias por niveles de cargos
 */
Route::get('objetivosresultadospornivel/{proyecto_id}/resultadosgeneralesnivel',"ObjetivosController@resultadosGeneralesNivel")
->name('objetivo.resultadosgeneralesnivel')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

});


//Routes para lanzamiento de evaluaciones por objetivos del manager
Route::group(['middleware' => 'auth'], function() {

    Route::get('/lanzarobjetivo/index', 'LanzarObjetivoController@index')->name('lanzarobjetivo.index');

    Route::get('/lanzarobjetivo/{user}/seleccionarmetas',"LanzarObjetivoController@seleccionar")
    ->name('lanzarobjetivo.seleccionar')
    ->where('evaluado','[0-9]+');
    //->middleware(['role:admin']);

    Route::post('/lanzarobjetivo/{user}/procesar', 'LanzarObjetivoController@procesar')->name('lanzarobjetivo.procesar');



});


//Routes para control de metas
Route::group(['middleware' => 'auth'], function() {
    Route::resource('meta', 'MetasController')
    ->middleware('role:admin');

    Route::post('meta/{id}/delete', 'MetasController@destroy')->name('metas.delete')
    ->middleware('role:admin');

    Route::post('submeta/{id}/delete', 'MetasController@submetadestroy')->name('submeta.delete')
    ->middleware('role:admin');

    Route::get('meta/{id}/copy', 'MetasController@copy')->name('meta.copy')
    ->middleware('role:admin');
});


//Routes para control de mediciones
Route::group(['middleware' => 'auth'], function() {
    Route::resource('medida', 'MedidaController')
    ->middleware('role:admin');

    Route::post('medida/{id}/delete', 'MedidaController@destroy')->name('medida.delete')
    ->middleware('role:admin');

});

//Routes para control de calificaciones
Route::group(['middleware' => 'auth'], function() {
    Route::resource('qualify', 'QualifyController')
    ->middleware('role:admin');

    Route::post('qualify/{id}/delete', 'QualifyController@destroy')->name('qualify.delete')
    ->middleware('role:admin');

});

//Routes para control de periodos
Route::group(['middleware' => 'auth'], function() {
    Route::resource('periodo', 'PeriodoController')
    ->middleware('role:admin');

    Route::post('periodo/{id}/delete', 'PeriodoController@destroy')->name('periodo.delete')
    ->middleware('role:admin');

});

//Routes para control de status de feedback
Route::group(['middleware' => 'auth'], function() {
    Route::resource('fbstatu', 'FBstatuController')
    ->middleware('role:admin');

    Route::post('fbstatu/{id}/delete', 'FBstatuController@destroy')->name('fbstatu.delete')
    ->middleware('role:admin');

});
/**
 * Route de plantillas de personal con la carga masiva
 *
 */
Route::middleware(['auth', 'role:admin'])->group( function() {

    Route::get('/plantillas/{plantilla}/organigrama', 'PlantillasController@organigrama')->name('plantillas.organigrama');

    Route::get('/plantillas/userimport', 'PlantillasController@userimport');

    Route::get('/plantillas/index', 'PlantillasController@index')->name('plantillas.index');

    Route::post('/plantillas/{id}/procesar', 'PlantillasController@procesar')->name('plantillas.procesar');

    Route::post('/plantillasdelete/{id}/delete', 'PlantillasController@destroy')->name('plantillas.delete');

    Route::get('/plantillas/verproyecto/{id}', 'PlantillasController@verproyecto')->name('plantillas.verproyecto');

    Route::post('/plantillas/upload', 'PlantillasController@upload')->name('plantillas.upload');

    Route::get('/plantillas/fileupload', 'PlantillasController@fileupload')->name('plantillas.fileupload');

    Route::get('/plantillas/{id}/lanzar', 'PlantillasController@lanzar')->name('plantillas.lanzar');

    Route::post('/plantillas/{id}/crearevaluaciones', 'PlantillasController@crearevaluaciones')->name('plantillas.crearevaluaciones');
});

//Routes para control de evaluaciones del manager
Route::group(['middleware' => 'auth'], function() {
    Route::get('/manager/index', 'ManagerController@index')->name('manager.index');

    Route::get('/manager/staff/{id}', 'ManagerController@staff')->name('manager.staff');

    Route::get('/manager/personal', 'ManagerController@personal')->name('manager.personal');

    Route::get('manager/historico/evaluaciones/{id}', 'ManagerController@historicoevaluaciones')
    ->name('manager.historicoevaluaciones'); // Manager

    Route::get('managerobjetivosporproyecto', 'ManagerController@objetivosporproyecto')
    ->name('manager.objetivosporproyecto'); // Manager

    Route::get('managerconsolidar/{evaluado_id}/consolidar', 'ManagerController@consolidar')
    ->name('manager.consolidar'); // Manager

    Route::get('/plantillas/downloads', function () {
        return Storage::download("plantilla.xlsx");
        abort(404);
    })->where(['file' => '(.*?)\.(xlsx|json|jpg|png|jpeg|gif)$'])->name('plantillas.downloads');

});


/**
 * Permite la descarga del archivo en formato json establecido para subir datos
 *
 */
Route::get('/plantillas/downloads', function () {
    return Storage::download("plantilla.xlsx");

    abort(404);
})->where([
    'file' => '(.*?)\.(xlsx|json|jpg|png|jpeg|gif)$'
])->name('plantillas.downloads')
->middleware(['auth']);


/**
 * Route de Feedback de evaluacion
 *
 */
Route::middleware(['auth'])->group( function() {


    Route::get('feedback/{id}/edit', 'FeedBackController@edit')
    ->name('feedback.edit');
    // ->middleware('role:user');

    Route::post('feedback/update/{id}', 'FeedBackController@update')->name('feedback.update');
    // ->middleware('role:user');

    /**
     * Permite la exportar del feedback en archivo en excel xlsx
     *
     */

    Route::get('feedback/export/{evaluado}', 'FeedBackController@exportFeedBack')->name('feedBack->exportfeedback');

});

/**
* Route de notificaciones de evaluaciones
*
*/
Route::middleware(['auth', 'role:admin'])->group( function() {

Route::get('notificaciones/all/{id}', 'NotificacionesController@all')->name('notificaciones.all')
->middleware('role:admin');

Route::get('notificaciones/unread/{id}', 'NotificacionesController@unread')->name('notificaciones.unread')
->middleware('role:admin');

Route::get('notificaciones/markasread/{id}', 'NotificacionesController@markasread')->name('notificaciones.markasread')
->middleware('role:admin');

});


Route::middleware(['auth', 'role:admin'])->group( function() {

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

    Route::resource('ubicacion', 'DepartamentoController')
    ->middleware('role:admin');

    Route::post('ubicacion/delete/{id}','DepartamentoController@destroy')->name('departamento.delete');
    /**
    * Route de User
    *
    */
    Route::get('/user/list', 'UserController@index')->name('index');
    Route::post('user/delete/{id}', 'UserController@destroy')->name('user.delete')->middleware('role:admin');
    Route::resource('user', 'UserController')->middleware('role:admin');

});

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
// Route::get('home', 'HomeController@vision360')->name('vision360');

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
Route::middleware(['auth'])->group( function() {
Route::get('talent360', 'TalentController@indexevaluado')->name('talent.index')
->middleware('role:admin');

Route::get('talent360/manager', 'TalentController@indexmanager')->name('talent.manager')
->middleware('manager:manager','role:user');

Route::get('talent360/historico/evaluaciones/{id}', 'TalentController@historicoevaluaciones')
->name('talent.historicoevaluaciones'); //Administrador y Manager

Route::get('talent360/{id}/create/evaluado', 'TalentController@createevaluado')->name('talent.createevaluado')
->middleware('role:admin');

Route::post('talent360/store/evaluado/{id}', 'TalentController@storeevaluado')->name('talent.storeevaluado')
->middleware('role:admin');
});

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
Route::post('sendemailevaluador','AjaxController@sendEmailEvaluador')->name('ajaxsendemailevaluador')
->middleware('role:admin');

//Envio de correo a evaluador para responder el cuestionario
Route::post('/changeemailevaluador','AjaxController@changeEmailEvaluador')->name('ajaxchangeemailevaluador')
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
 * Route de evaluaciones de competencias blandas
*/

/**
 * Evaluador con logueo con token a la prueba
*/

Route::get('evaluacion/{token}/evaluacion',"EvaluacionController@token")
->name('evaluacion.token');

Route::group(['middleware' => 'auth'], function() {


    /**
     * Presenta las competencias al evaluador
    */
    Route::get('competencias/{evaluador}/evaluacion',"EvaluacionController@competencias")
    ->name('evaluacion.competencias');

    /**
     * Pregunta de la prueba
    */
    Route::get('evaluacionget/{competencia}/responder',"EvaluacionController@responder")
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
});


/**
* Resultados de las pruebas
*/
Route::get('resultados/{evaluado_id}/evaluacion',"ResultadosController@resultados")
->name('resultados.evaluacion')
->middleware(['auth']);
//->middleware(['auth','role:admin']);
Route::get('resultados/{evaluado_id}/finales',"ResultadosController@resumidos")
->name('resultados.finales')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);
/**
 * Presenta una grafica con resultados 360
 */
Route::get('resultados/{evaluado_id}/charindividual',"ResultadosController@charindividual")
->name('resultados.charindividual')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

/**
 * Presenta una grafica de resultados personales por subproyecto
 */
Route::get('resultados/{subproyecto_id}/charpersonalporgrupo',"ResultadosController@charpersonalporgrupo")
->name('resultados.charpersonalporgrupo')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

/**
 * Presenta una tabla de analisis personales tabulados por subproyecto
 */
Route::get('resultados/{subproyecto_id}/cumplimiento',"ResultadosController@analisiscumplimiento")
->name('resultados.analisiscumplimiento')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

/**
 * Presenta la grafica de competencias por tipo
 */
Route::get('resultados/{proyecto_id}/resultadosgeneralestipo',"ResultadosController@resultadosGeneralesTipo")
->name('resultados.resultadosgeneralestipo')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);
/**
 * Presenta la grafica de competencias por niveles de cargos
 */
Route::get('resultados/{proyecto_id}/resultadosgeneralesnivel',"ResultadosController@resultadosGeneralesNivel")
->name('resultados.resultadosgeneralesnivel')
->middleware(['auth']);
// ->middleware(['auth','role:admin']);

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


/**Route para sms */
Route::get('sms/welcome/{id}','SendSMSController@welcome')->middleware(['auth']);

Route::get('sms/welcomeFacade','SendSMSController@welcomeFacade')->middleware(['auth']);

