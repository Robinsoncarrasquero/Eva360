<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    //
    protected $table='feedbacks';

    protected $fillable=['competencia','feedback','fb_finicio','fb_ffinal','fb_status','fb_nota','unidades','evaluado_id','medida_id'];

    //Un feedback pertenece a un evaluado
    public function evaluado(){
        return $this->belongsTo(Evaluado::class);
    }

     //Un feedback pertenece a un periodo
     public function periodo(){
        return $this->belongsTo(Periodo::class);

    }

     //Un feedback pertenece a un status
     public function fbstatu(){
        return $this->belongsTo(FBstatu::class);

    }
}
