<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Competencia extends Model
{
    //

    protected $fillable=['name','description','tipo'];

    public function grados(){

        return $this->hasMany(Grado::class);

    }

}
