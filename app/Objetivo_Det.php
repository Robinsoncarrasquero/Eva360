<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objetivo_Det extends Model
{
    use HasFactory;
    protected $table='objetivos_dets';

    protected $fillable=['objetivo_id','submeta_id','valormeta','peso','cumplido'];
    protected $casts = [
        'cumplido' => 'float',
    ];

    //Una detalle de objetivo pertenece a un objetivo
    public function objetivo(){
        return $this->belongsTo(Objetivo::class);
    }
    //Un detalle de objetivo pertenece a un submeta
    public function submeta(){
        return $this->belongsTo(SubMeta::class);

    }
}
