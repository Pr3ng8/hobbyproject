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

    public function hasAccess(): string {

        return $this->roles->first()->attributesToArray()['name'];
        
    }

    public function hasPermission() 
    {
        return DB::table('role_user')
        ->join('users','role_user.user_id','=','users.id')
        ->where( 'role_user.user_id' , '=', $this->id )
        ->select('role_user.status')
        ->first()
        ->status;

    }

    public function getFullName(): string {

        return $this->first_name . ' ' . $this->last_name;

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

    /**
     * Get the status record associated with the user.
     */
    public function status()
    {
        return $this->hasOne('App\UserStatus');
    }
}
