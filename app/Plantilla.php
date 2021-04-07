<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    //
    protected $table='plantillas';

    protected $fillable = [
        'ubicacion','name', 'dni','email', 'email_super','celular','manager','cargo','carga_masivas_id','nivel_cargo',
    ];


    protected $guarded = [];

    /**
     * Una plantilla pertenece a una carga masiva
    */
    public function carga_masiva(){
        return $this->belongsTo(CargaMasiva::class,'carga_masivas_id');
    }

}
