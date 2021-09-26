<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    protected $table='paypals';

    protected $fillable=[
        'payid','intent','state','name','total','currency',
    ];


}
