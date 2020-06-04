<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluador extends Model
{
    //
    protected $table='evaluadores';

    protected $fillable=[
        'name','email','relation','status','remember_token','evaluado_id'

    ];

    public function evaluado(){
        return $this->belongsTo(Evaluado::class);
    }

    //Un evaluador tiene una sola evaluacion
    public function evaluacion(){
        return $this->hasOne(Evaluacion::class);
    }

}
