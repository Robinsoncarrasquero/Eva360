<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table='roles';


    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('name');

    }
    public function userss()
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }




}
