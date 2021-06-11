<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    //
    protected $table='grados';
    protected $fillable=['grado','description','ponderacion','frecuencia','competencia_id'];

    public function competencia(){

        return $this->belongsTo(Competencia::class);
    }

}
