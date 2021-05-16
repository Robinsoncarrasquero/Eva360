<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{

    //
    protected $table='metas';

    protected $fillable=['name','description','tipo_id','nivelrequerido'];

    //Una meta tiene una o mas submetas
    public function submetas(){
        return $this->hasMany(SubMeta::class);
    }


    //Una meta tiene uno o mas objetivos
    public function objetivos(){
        return $this->hasMany(Objetivo::class);
    }

    //Una meta pertenece o esta asociado a un tipo
    public function tipo(){
        return $this->belongsTo(Tipo::class);
    }
}
