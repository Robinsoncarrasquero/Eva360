<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Evaluador extends Model
{
    //
    use Notifiable;

    protected $table='evaluadores';

    protected $fillable=[
        'name',
        'email',
        'relation',
        'status',
        'remember_token',
        'evaluado_id',
        'linkweb','virtual',

    ];

    //Un evaluador pertenece a un evaluado
    public function evaluado(){
        return $this->belongsTo(Evaluado::class);
    }

    //Un evaluador tiene una o muchas evaluaciones
    public function evaluaciones(){
        return $this->hasMany(Evaluacion::class);
    }

    public function competencias()
    {
        return $this->hasManyThrough('App\Competencia', 'App\Evaluacion','evaluador_id','id','id','competencia_id');
    }

    //Un evaluador pertenece a un usuario
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function metas()
    {
        return $this->hasManyThrough('App\Meta', 'App\Objetivo','evaluador_id','id','id','meta_id');
    }

       //Un evaluador tiene uno o muchas evaluaciones por objetivos asociados
       public function objetivos(){
        return $this->hasMany(Objetivo::class);
    }


}
