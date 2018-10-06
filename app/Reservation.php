<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
   
    use SoftDeletes;

    protected $table = 'reservations'; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boat_id',
        'user_id',
        'number_of_passengers',
        'limit',
        'start_of_rent',
        'end_of_rent'
    ];

    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function boats() {

        return $this->belongsTo('App\Boat','boat_id','id');

    }

    public function users() {
        
        return $this->belongsTo('App\User');

    }
}
