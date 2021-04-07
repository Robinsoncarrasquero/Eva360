<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargaMasiva extends Model
{
    //
    protected $table='carga_masivas';

    protected $fillable = [
        'name','description','metodo', 'procesado','modelo_id','file','metodos',
    ];

    protected $guarded = [];

    /**
     * Una carga_masiva tiene n registros
    */
    public function plantillas(){
        return $this->hasMany(Plantilla::class,'carga_masivas_id');
    }

    /**
     * Una carga_masiva tiene n registros
    */
    public function proyectos(){
        return $this->hasMany(Proyecto::class,'carga_masivas_id');
    }

    /**
     * Una carga_masiva pertenece a un modelo
    */
    public function modelo(){
        return $this->belongsTo(Modelo::class,'modelo_id');
    }

}
