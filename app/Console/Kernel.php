<?php

namespace App\Console;

use app\CustomClass\Simulador;
use App\Evaluador;
use App\Notifications\EvaluacionPendiente;
use App\Notifications\TareaPendienteDeEvaluacion;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $receptores = Evaluador::where('status',1)->where('virtual',false)->get();;
            Notification::send($receptores, new TareaPendienteDeEvaluacion('evaluacion.token'));
        })->dailyAt('13:00')->weekdays();
        //})->twiceDaily(11, 14)->weekdays();
        //})->everyMinute()->weekdays();
        //Ejecuta la tarea diariamente a la 1:00 & 13:00

        //Evaluados Virtuales que no terminaron la prueba
        //El robot responde la prueba y envia correo de resultados
        $schedule->call(function () {
            $evaluadores = Evaluador::where(['virtual'=>true,'relation'=>'Autoevaluacion'])->get();
            $abandonadores = $evaluadores->reject(function ($evaluador) {
                return $evaluador->status==2;
            });
            Simulador::responderPruebaOlvidada($abandonadores);
        //})->dailyAt('10:00')->weekdays();
        })->everyMinute();
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
