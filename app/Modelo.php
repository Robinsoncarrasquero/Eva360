<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    //
    protected $table='modelos';

    protected $fillable=['name','description'];

    //Hacer busquedas por nombre
    public function scopeName($query,$name){
        $query->where('name','like',"%$name%");

    }


    //Un modelo tiene uno o mas competencias
    public function competencias(){

        return $this->hasMany(ModeloCompetencia::class);

    }

    //Un modelo tiene una muchas carga masivas
    public function cargamasiva(){

        return $this->hasMany(CargaMasiva::class);

    }

}
