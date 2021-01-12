<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    //
    protected $table='configuraciones';

    protected $fillable=['sms','email'];



}
