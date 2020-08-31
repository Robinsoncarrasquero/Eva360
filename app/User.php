<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Hacer busquedas por nombre
    public function scopeName($query,$name){
        $query->where('name','like',"%$name%");

    }

    //Un Usuario(evaluador) realiza muchas evaluaciones(evaluador)
    public function evaluaciones(){
        return $this->hasMany(Evaluador::class);
    }

    public function roles() {
        return $this
            ->belongsToMany('App\Role')
            ->withTimestamps();
    }


    public function authorizeRoles($roles) {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'Esta acción no está autorizada.');
    }

    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role) {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function getNewPassResetUrl(){
        $token= Str::random(60);

        DB::table('password_resets')->where('email',$this->email)->delete();
        DB::table('password_resets')->insert([
            'email' => $this->email,
            'token' => Hash::make($token), //change 60 to any length you want
            'created_at' => \Carbon\Carbon::now()
        ]);
        return url('reset',$token);
    }

    /**Indica si el usuario es adminitrator*/
    public function admin(){

        return $this->hasRole('admin');

    }




}
