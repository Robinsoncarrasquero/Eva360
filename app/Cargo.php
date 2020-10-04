<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
    protected $table='cargos';

    protected $fillable=['name','description','nivel_cargo_id'];

    /**
     * Un cargo pertenece a un nivel de cargo
    */
    public function nivel_cargo(){
        return $this->belongsTo(NivelCargo::class);
    }
    /**
     * Un cargo tiene muchos evaluados
     */
    public function evaluado(){
        return $this->hasMany(Evaluado::class);
    }
}
