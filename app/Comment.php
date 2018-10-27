<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id',
        'post_id',
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

    ];

    /**
     * Get the post record associated with the comment.
     */
    public function post() {

        return $this->belongsTo('App\Post');

    }

    /**
     * Get the user record associated with the comment.
     */
    public function user() {

        return $this->belongsTo('App\User');
        
    }
}
