<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinalizacionEvaluacion extends Notification
{
    use Queueable;
    protected $evaluado;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evaluado)
    {
        //
        $this->evaluado=$evaluado;
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

        $url=Route('resultados.finales',$this->evaluado->id);
        return (new MailMessage)
            ->greeting('Hola.')
            ->line($notifiable->name)

            ->line('Estimado administrador, le notificamos que la Evaluacion de '.$this->evaluado->name.', ha finalizado. Revise los resultados.')
            ->action('Resultados', url($url))
            ->line('Gracias por utilizar nuestro Sistema de Evaluacion de Desempeño Por Competencias HR-FeedBack-360')
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
            'email'=> $this->notifiable->email,
        ];
    }
}
