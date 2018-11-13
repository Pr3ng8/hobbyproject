<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //Check if the user has any post
        if ( $user->posts->exists() ) {

            //Delete all post that belongs to the user
            $user->posts()->delete();

        }

        //Check if the user has any comment(s)
        if ( $user->comments->exists() ) {

            //Delete all comment(s) that belongs to the user
            $user->comments()->delete();

        }

        //Check if the user has any photo(s)
        if ( $user->photos->exists() ) {

            //Delete all photo(s) that belongs to the user
            $user->photos()->delete();

        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restoring(User $user)
    {
        
        //Check if the user has any post
        if ( $user->posts->exists() ) {
            //Restore all post that belongs to the user
            $user->posts()->restore();

        }

        //Check if the user has any comment(s)
        if ( $user->comments->exists() ) {

            //Restoring the deleted comment(s) thats belongs to the user
            $user->comments()->restore();

        }

        //Check if the user has any photo(s)
        if ( $user->photos->exists() ) {

            //Restore all photo(s) that belongs to the user
            $user->photos()->restore();

        }
    }

}