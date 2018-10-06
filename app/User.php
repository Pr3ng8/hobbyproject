<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'birthdate',
        'email',
        'password',
    ];

    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasAcces() {

        return $this->roles->first()->attributesToArray()['name'];
        
    }

    public function roles() {

        return $this->belongsToMany('App\Role');

    }

    public function reservations() {
        
        return $this->hasMany('App\Reservation');

    }

    public function posts() {

        return $this->hasMany('App\Post');

    }
}
