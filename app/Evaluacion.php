<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluacion extends Model
{
    //
    protected $table='evaluaciones';

    protected $fillable=['competencia_id','grado','pronderacion','frecuencia','evaluador_id'];

    /**
     * Una evaluacion pertenece a un evaluador
     */
    public function evaluador(){
        return $this->BelongsTo(Evaluador::class);
    }

}
