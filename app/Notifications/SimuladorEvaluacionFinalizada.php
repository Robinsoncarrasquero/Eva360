<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SimuladorEvaluacionFinalizada extends Notification
{
    use Queueable;
    protected $route;
    protected $evaluado;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($route,$evaluado)
    {
        //
        $this->route=$route;
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

        $url=Route($this->route,$this->evaluado->id);
        return (new MailMessage)
            ->greeting('Hola.')
            ->line($notifiable->name)

            ->line('Estimado usuario virtual, le notificamos que la Evaluacion Virtual ha finalizado.')
            ->action('Resultados', url($url))
            ->line('Gracias por utilizar el Robot de AutoEvaluacion virtual.')
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
