<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
     protected $table='proyectos';

     protected $fillable=[
     'name',
     'description',
     'carga_masivas_id',
     'virtual'];

    //Hacer busquedas por nombre
    public function scopeName($query,$name){
        $query->where('name','like',"%$name%");

    }

     /**
     * Una Proyecto pertenece a una carga masiva
    */
    public function carga_masiva(){
        return $this->belongsTo(CargaMasiva::class,'carga_masivas_id');
    }

    public function subproyectos(){
        return $this->hasMany(SubProyecto::class);
    }


}
