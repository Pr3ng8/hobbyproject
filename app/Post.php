<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Post extends Model
{
    use SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    public function user() {

        return $this->belongsTo('App\User');
        
    }

    /**
     * Get the photos record associated with the user.
     */
    public function photos() {

        return $this->morphOne('App\Photo','imageable');
        
    }

    /**
     * Get the comments record associated with the user.
     */
    public function comments() {

        return $this->hasMany('App\Comment');
        
    }



}
