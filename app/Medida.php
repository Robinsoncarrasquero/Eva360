<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    //
    protected $table='medidas';

    protected $fillable=['name','description','medida'];
}
