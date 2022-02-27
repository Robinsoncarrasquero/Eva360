<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMeta extends Model
{
    //
    protected $table='submetas';
    protected $fillable=['submeta','description','requerido','meta_id','valormeta','peso'];

    //Una submeta pertecene a una meta
    public function meta(){

        return $this->belongsTo(Meta::class);
    }

    //Un detalle de objetivo pertene a una submeta
    public function objetivos_det(){

        return $this->belongsTo(Objetivo_Det::class);
    }

}
