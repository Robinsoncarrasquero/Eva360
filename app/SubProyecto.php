<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubProyecto extends Model
{
    //
    protected $table='subproyectos';

    protected $fillable=['name','description','proyecto_id','tipo'];

     /**
     * Un subproyecto pertenece a un proyecto
     **/
    public function proyecto(){
        return $this->belongsTo(Proyecto::class);
    }

    public function evaluados(){
        return $this->hasMany(Evaluado::class,'subproyecto_id')->orderBy('created_at','DESC');
    }



}
