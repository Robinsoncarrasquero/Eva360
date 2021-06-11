<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comportamiento extends Model
{
    //
    protected $table='comportamientos';

    protected $fillable=['evaluacion_id','grado_id','ponderacion','frecuencia','resultado'];
    protected $casts = [
        'frecuencia' => 'integer',
    ];

    //Un Comportamiento pertenece a una evaluacion
    public function evaluacion(){
        return $this->belongsTo(Evaluacion::class);
    }
    //Una comportamiento tiene uno o mas grados
    public function grado(){
        return $this->belongsTo(Grado::class);

    }


}
