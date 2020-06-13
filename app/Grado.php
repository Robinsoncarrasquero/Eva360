<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    //
    protected $fillable=['grado','description','ponderacion','frecuencia','competencia_id'];

    public function competencias(){

        return $this->belongsTo(Competencia::class);
    }

}
