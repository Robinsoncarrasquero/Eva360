<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Frecuencia extends Model
{
    //
    protected $table='frecuencias';

    protected $fillable=['name','valor'];

    public function getValorAttribute()
    {
        # code...
        return $this->attributes['valor'];
    }

}
