<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    protected $table='objetivos';

    protected $fillable=['id','meta_id','evaluador_id',
        	'medida_id',
            'submeta',
            'requerido',
            'cumplida',
            'finicio','ffinal',
            'status',
            'description','nota'
    ];
    protected $casts = [
        'requerido' => 'float',
        'cumplida' => 'float'
    ];

    /**
     * Un objetivo pertenece a un evaluador
     */
    public function evaluador(){
        return $this->belongsTo(Evaluador::class);
    }

    //Un objetivo esta relacionada con una competencia(meta)
    public function meta(){
        return $this->belongsTo(Meta::class);
    }

    //Un objetivo tiene varias detalle de objetivos
    public function objetivos(){
        return $this->hasMany(Objetivo_Det::class);
    }




}
