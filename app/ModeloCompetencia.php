<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeloCompetencia extends Model
{

    protected $table='modelos_competencias';

    protected $fillable=['modelo_id','competencia_id','nivelrequerido'];

    //Un competencia esta asociada a un modelo
    public function competencia(){
        return $this->belongsTo(Competencia::class);
    }
    //Un modelo-competencia pertenece a un modelo
    public function modelo(){
        return $this->belongsTo(Modelo::class);
    }





}
