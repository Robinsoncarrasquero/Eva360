<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluado extends Model
{
    /**
    * The Table associated with the model evaluados
    */
    protected $table= "evaluados";

    /**
    * The fillable fields
    */
    protected $fillable = [
        'name', 'word_key', 'status',
    ];

    protected $attributes=[
        'status'=>0,

    ];
    //Relacion 1 a muchos
    public function evaluadores(){
        return $this->hasMany(Evaluador::class);
    }

    //Hacer busquedas por nombre
    public function scopeName($query,$name){

        $query->where('name','like',"%$name%");

    }


}
