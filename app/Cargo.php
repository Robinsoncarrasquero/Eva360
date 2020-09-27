<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
    protected $table='cargos';

    protected $fillable=['name','description','nivel_cargos_id'];
    /**
     * Un cargo pertenece a un nivel de cargo
    */
    public function nivel(){
        return $this->belongsTo(NivelCargo::class);
    }
}
