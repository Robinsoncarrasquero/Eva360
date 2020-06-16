<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    protected $table='emailsends';


    protected $fillable=[
        'nameEvaluador','email','relation','linkweb','nameEvaluado'

    ];


    //
}
