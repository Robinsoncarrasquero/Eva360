<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluacion extends Model
{
    //
    protected $table='evaluaciones';

    protected $fillable=['competencia_id','grado','ponderacion','frecuencia','evaluador_id'];
    protected $casts = [
        'frecuencia' => 'integer',
    ];


    /**
     * Una evaluacion pertenece a un evaluador
     */
    public function evaluador(){
        return $this->belongsTo(Evaluador::class);
    }

    //Una Evaluacion esta relacionada con una competencia
    public function competencia(){
        return $this->belongsTo(Competencia::class);
    }

    public function setFrecuenciaAttribute($value)
    {
        $this->attributes['frecuencia'] = is_string($value) ? intval($value) : $value;
    }

    //Una evaluacion tiene varios comportamientos
    public function comportamientos(){
        return $this->hasMany(Comportamiento::class);
    }

}
