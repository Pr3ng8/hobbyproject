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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Before we calling the delete() method call this
        static::deleting(function($post) { 
            //Deletes comments thats are belogns to the post
             $post->comments()->delete();
        });

        // Before we calling the restore() method call this
        static::restoring(function($post) {
            //Restoring the deleted comments
            $post->comments()->restore();
        });
    }

    
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
