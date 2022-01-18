<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Par extends Model
{
    protected $table='pares';

    protected $fillable = [
        'user_id', 'user_id_par',
    ];




}
