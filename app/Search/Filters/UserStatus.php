<?php

namespace App\Search\Filters;

use Illuminate\Database\Eloquent\Builder;

class Usertatus implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param Builder $builder
     * @param mixed $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        switch ( $value ) {

            //If we want all the users
            case "all" :

                try {
                    //Get all users even if they are deleted
                    $builder = $builder->withTrashed();

                } catch ( \Exception $e ) {

                    return $e->getMessage();

                }
                
                break;
            
            //If we want only the active users
            case "active" :
                //We do not have to do enything in this case
                break;
            
            //If we want only the soft deleted users
            case "trashed" :

                try {
                    //Get only the deleted users
                    $builder = $builder->onlyTrashed();

                } catch ( \Exception $e ) {

                    return $e->getMessage();

                }
            
                break;
            
            //For defailt we ant active and soft deleted users
            default :

                try {
                    //Get all users even if they are deleted
                    $builder = $builder->withTrashed();

                } catch ( \Exception $e ) {

                    return $e->getMessage();

                }
            
                break;
        }

    }

}