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
        'name', 'email', 'password','active','codigo','departamento_id','cargo_id','phone_number','email_super'
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

    public function roles()
    {

        return $this->belongsToMany(Role::class)->withTimestamps();

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

    // public function roles_user()
    // {
    //     return $this->hasManyThrough('App\Role', 'App\Role_User','user_id','id','id','role_id');

    // }

    //Relacion usuario es manager
    public function is_manager(){
        return $this->hasOne(Departamento::class,'manager_id');
    }

    //Un usuario / empleado pertenece a un departamento)
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    //Un usuario pertenece a un cargo
    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    //Un Evaluador(user) tiene 1 o muchas evaluados
    public function evaluadores(){
       return $this->hasMany(Evaluador::class);
    }

    //Un usuario puede tener varias evaluaciones
    public function evaluaciones(){
        return $this->hasMany(Evaluado::class);
    }




    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return $this->phone_number;
    }

     /**Indica si el usuario es adminitrator*/
     public function name_short(){
        $namex=explode(" ",$this->name);
        return $namex[0];

    }







}
