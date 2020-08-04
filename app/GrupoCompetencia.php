<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoCompetencia extends Model
{
    //

    protected $table='grupocompetencias';

    protected $fillable=['name','description','nivelrequerido','tipo_id'];

    public function competencias(){

        return $this->hasMany(Competencia::class);
    }
    //Una competencias pertenece a un tipo
    public function tipo(){
        return $this->belongsTo(tipo::class);
    }


}
