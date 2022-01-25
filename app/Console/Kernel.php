<?php

namespace App\Console;

use App\Evaluador;
use App\Notifications\EvaluacionPendiente;
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
            $receptores = Evaluador::where('status',1)->get();
            Notification::send($receptores, new EvaluacionPendiente());
        //})->twiceDaily(9, 14);
        })->everyMinute();
        //Ejecuta la tarea diariamente a la 1:00 & 13:00
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
