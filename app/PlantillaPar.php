<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantillaPar extends Model
{
    protected $table='plantillapares';

    protected $fillable = [
        'email_par', 'email_evaluado','carga_masivas_id',
    ];

    /**
     * Una plantilla par pertenece a una carga masiva
    */
    public function carga_masiva(){
        return $this->belongsTo(CargaMasiva::class,'carga_masivas_id');
    }
}
