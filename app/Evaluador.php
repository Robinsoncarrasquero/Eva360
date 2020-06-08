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

    //Un evaluador pertenece a un evaluado
    public function evaluado(){
        return $this->belongsTo(Evaluado::class);
    }

    //Un evaluador tiene una o muchas evaluaciones
    public function evaluaciones(){
        return $this->hasMany(Evaluacion::class);
    }

}
