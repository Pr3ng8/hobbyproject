<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that contains the table name.
     *
     * @var string
     */
    protected $table = 'users_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    /**
     * Get the userstatus record associated with the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
