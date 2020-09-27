<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubProyecto extends Model
{
    //
    protected $table='subproyectos';

    protected $fillable=['name','description','proyectos_id'];

     /**
     * Un subproyecto pertenece a un proyecto
     **/
    public function proyecto(){
        return $this->belongsTo(Proyecto::class);
    }

}
