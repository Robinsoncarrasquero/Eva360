<?php

namespace App\Http\Controllers;

use App\Notifications\Nexmosms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Nexmo\Laravel\Facade\Nexmo;

class NotificacionesController extends Controller
{

    /**
     * Display a notificaciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function all($id)
    {
        $user = User::find($id);

        foreach ($user->notifications as $notification) {
            echo $notification->type;
        }

    }

    /**
     * Display las notificaciones sin leer.
     *
     * @return \Illuminate\Http\Response
     */

    public function unread($id)
    {
       $user = User::find($id);

       foreach ($user->unreadNotifications as $notification) {
           echo $notification->type;
       }

    }

    /**
     * Marcar las notificaciones como leidas.
     *
     * @return \Illuminate\Http\Response
     */

    public function markasread($id)
    {
        $user = User::find($id);

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }

    /**
     * Delete una notificacion.
     *
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        $user = User::find($id);
        $user->notifications()->delete();
    }

    /**
     * Desmarcar todas las notificaciones como leidas directamenteb en la bd sin retraer registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function markasreadall($id)
    {
        $user = User::find(1);
        $user->unreadNotifications()->update(['read_at' => now()]);
    }



}
