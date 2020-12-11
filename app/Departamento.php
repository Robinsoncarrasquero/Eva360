<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    protected $table='departamentos';

    protected $fillable=['name','description'];

     /**
     * Un cargo tiene muchos Empleados Usuarios
     */
    public function empleados(){
        return $this->hasMany(User::class,'departamento_id');
    }

}
