<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
     protected $table='proyectos';

     protected $fillable=['name','description'];

    //Hacer busquedas por nombre
    public function scopeName($query,$name){
        $query->where('name','like',"%$name%");

    }

    /** Un Proyecto tiene subproyectos */
    public function subproyecto(){
         return $this->hasMany(SubProyecto::class);
     }

}
