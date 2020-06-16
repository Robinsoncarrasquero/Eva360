<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Competencia extends Model
{
    //
    protected $table='competencias';

    protected $fillable=['name','description','tipo'];

    public function grados(){

        return $this->hasMany(Grado::class);

    }
    //Una competencias tiene una o mas evaluaciones
    public function evaluaciones(){
        return $this->hasMany(Evaluacion::class);
    }

}
