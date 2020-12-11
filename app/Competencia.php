<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Competencia extends Model
{
    //
    protected $table='competencias';

    protected $fillable=['name','description','tipo_id','nivelrequerido'];

    //Una competencia tiene uno o mas grados
    public function grados(){

        return $this->hasMany(Grado::class);

    }
    //Una competencias tiene una o mas evaluaciones
    public function evaluaciones(){
        return $this->hasMany(Evaluacion::class);
    }

    //Una competencia pertenece a un tipo
    public function tipo(){
        return $this->belongsTo(Tipo::class);
    }

    //Una competencia pertenece a un grupo
    public function grupocompetencia(){
        return $this->belongsto(GrupoCompetencia::class);
    }

}
