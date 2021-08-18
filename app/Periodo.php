<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    //
    protected $table='periodos';
    protected $fillable=['name','description'];

    //Un feedback tiene periodo
    public function feedback(){
        return $this->hasOne(feedback::class);
    }
}
