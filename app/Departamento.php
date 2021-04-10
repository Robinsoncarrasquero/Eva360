<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $table='departamentos';

    protected $fillable=['name','description','manager_id'];

    //Hacer busquedas por nombre
    public function scopeName($query,$name){
        $query->where('name','like',"%$name%");

    }
     /**
     * Un cargo tiene muchos Empleados Usuarios
     */
    public function empleados(){
        return $this->hasMany(User::class,'departamento_id');
    }

     //Un usuario es manager
     public function user(){
        return $this->hasOne(User::class,'manager_id');
    }




}
