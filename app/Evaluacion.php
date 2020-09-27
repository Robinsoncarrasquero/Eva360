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

    //Una Evaluacion esta relacionada con una competencias
    public function competencia(){
        return $this->belongsTo(Competencia::class);
    }

    public function setFrecuenciaAttribute($value)
    {
        # code...

        $this->attributes['frecuencia'] = is_string($value) ? intval($value) : $value;


    }

}
