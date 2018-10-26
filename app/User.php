<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\{DB};
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

    /**
     * Get the user's role.
     * @return string
     */
    public function hasAccess(Array $array) {

        if(count($array) <= 0 || empty($array) || !is_array($array) || is_null($array)) return false;

        $length = count($array);

        for($i = 0;$i < $length; $i++) {

            if( in_array($array[$i], $this->roles->first()->attributesToArray()) ) return true;

        }

        return false;
        
        
    }
    public function getRole() {

        return $this->roles->first()->attributesToArray()['name'];
         
     }
    /**
     * Check if the user has permission to make a reservation.
     * @return int
     */
    public function hasPermission() : int
    {
        return $this->status->status;
    }

    /**
     * Get the full name of the user.
     * @return string
     */
    public function getFullName(): string {

        return $this->first_name . ' ' . $this->last_name;

    }

    /**
     * Get the roles record associated with the user.
     */
    public function roles() {

        return $this->belongsToMany('App\Role');

    }

    /**
     * Get the reservations record associated with the user.
     */
    public function reservations() {
        
        return $this->hasMany('App\Reservation');

    }

    /**
     * Get the posts record associated with the user.
     */
    public function posts() {

        return $this->hasMany('App\Post');

    }

    /**
     * Get the status record associated with the user.
     */
    public function status()
    {
        return $this->hasOne('App\UserStatus');
    }

    /**
     * Get the photos record associated with the user.
     */
    public function photos() {

        return $this->morphOne('App\Photo','imageable');
        
    }
}
