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
        'name', 'word_key', 'status','subproyecto_id','cargo_id'
    ];


    //Una evaluado tiene muchos evaluadores
    public function evaluadores(){
        return $this->hasMany(Evaluador::class);
    }

    //Un evaluado pertenece a un subproyecto
    public function subProyecto(){
        return $this->belongsTo(SubProyecto::class);
    }

    //Un evaluado pertenece a un cargo
    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    //Hacer busquedas por nombre
    public function scopeName($query,$name){
        $query->where('name','like',"%$name%");

    }

    //Hacer busquedas por nombre
    public function scopeEvaluado($query,$name,$user_id){

        $query->where('name','like',"%$name%",'and','id','=',$user_id);

    }


    public function setStatusAttribute($value)
    {
        # code...

        $this->attributes['status'] = is_string($value) ? intval($value) : $value;


    }


}
