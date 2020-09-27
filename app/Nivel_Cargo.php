<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel_Cargo extends Model
{
    //
    protected $table='nivel_cargos';

    protected $fillable=['name','description'];

     /**
     * Un nivel de cargo tiene muchos cargos relacionados
     *
     */
    public function cargos(){
        return $this->hasMany(Cargo::class);
    }

}
