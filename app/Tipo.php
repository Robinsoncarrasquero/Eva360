<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    //
    protected $table='tipos';

    protected $fillable=['tipo'];

    /**
     * Un tipo(General, especifica,etc) tiene una o muchas competencias relacionadas
     *
     */
    public function competencias(){
        return $this->hasMany(Competencia::class);
    }


}
