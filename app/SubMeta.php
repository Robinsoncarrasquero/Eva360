<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMeta extends Model
{
    //
    protected $table='submetas';
    protected $fillable=['submeta','description','requerido','meta_id'];

    //Una submeta pertecene a una meta
    public function meta(){

        return $this->belongsTo(Meta::class);
    }


}
