<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use App\Traits\UserTrait;

class User extends Authenticatable
{
    //use Notifiable, UserTrait;
   // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'empresa', 'password',
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

    public function empresa()
    {
        return $this->hasOne('App\Empresa');
    }

    public function roles(){

        return $this->belongsToMany('App\Role')->withTimesTamps();

    }

    public function adicionals(){

        return $this->hasMany('App\Adicional');

    }

    public function salarios(){

        return $this->hasMany('App\Salario');

    }

    public function soportes(){

        return $this->hasMany('App\Soporte');

    }

    public function soportents(){

        return $this->hasMany('App\Soportent');

    }

    public function correspondencias(){

        return $this->belongsToMany('App\Correspondencia')->withTimesTamps();

    }

    public function recorridos(){

        return $this->belongsToMany('App\Recorrido')->withTimesTamps();

    }

   public function dilioperador()
   {
      return $this->hasMany('App\Dilioperador');
   }

   public function diligencia()
   {
      return $this->hasMany('App\Diligencia');
   }

    public function havePermission($permission){

        foreach ($this->roles as $role ) {

            if ($role['full-access'] =='yes' ) {
                return true;
            }

            foreach ($role->permissions as $perm) {

                if ($perm->slug == $permission ) {
                    return true;
                }
            }



        }

        return false;
        //return $this->roles;
    }

}
