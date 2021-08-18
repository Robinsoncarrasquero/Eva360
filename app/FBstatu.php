<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FBstatu extends Model
{
    //
    protected $table='fbstatus';
    protected $fillable=['name','description'];

    //Un feedback tiene status
    public function feedback(){
        return $this->hasOne(feedback::class);
    }
}
