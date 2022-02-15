<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table='role_user';

    public function role()
    {
        //return $this->belongsToMany(Role::class);
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function admin()
    {
        return $this->belongsToMany(Role::class)
                ->wherePivot('name', 'admin');

    }
}
