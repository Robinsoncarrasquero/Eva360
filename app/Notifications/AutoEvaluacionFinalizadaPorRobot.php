<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutoEvaluacionFinalizadaPorRobot extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evaluador)
    {
        //
        $this->evaluador=$evaluador;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url=Route('simulador.tokenresultado',$this->evaluador->remember_token);
        return (new MailMessage)
            ->greeting('Hola.')
            ->line($notifiable->name)

            ->line('Estimado usuario virtual, le notificamos que la Auto Evaluacion Virtual ha finalizado.
            La evaluacion fué completada por el Robot por estar incompleta. Las Evaluaciones estan configuradas con un tiempo máximo 10 minutos para completarla.')
            ->action('Resultados', url($url))
            ->line('Gracias por experimentar con el Sistema de Evaluaciones de Desempeño Por Competencias HR-FeedBack-360')
            ->line('Vuelva pronto y haga otra Auto Evaluacion simulada con el mismo usuario registrado.')
            ->salutation('Saludos');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'evaluado_id' => $this->notifiable->id,
            'name' => $this->notifiable->name,
            'email'=> $this->notifiable->user->email,
        ];
    }
}
