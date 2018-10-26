<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file',
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that tells in which folder we put the photos
     *
     * @var const string
     */
    private const folder = 'images';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get all of the owning imageable models.
     * The  imageable_type column is how the ORM determines which "type"
     * of owning model to return when accessing the imageable relation.
     */
    public function imageable() {

        $this->morphTo();

    }
    /**
     * When we are retrieving the file attribute we ant to attacht the folder to it.
     * 
     */
    public function getfileAttribute() {
        return;
    }
}
