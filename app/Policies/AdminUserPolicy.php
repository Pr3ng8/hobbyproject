<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->hasAccess(["administrator"]); //Check if the user is administrator
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user)
    {
         return $user->hasAccess(["administrator"]); //Check if the user is administrator
    }


    /**
     * Determine whether the user can update the model.
     *
     * 
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasAccess(["administrator"]); //Check if the user is administrator
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasAccess(["administrator"]); //Check if the user is administrator
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->hasAccess(["administrator"]); //Check if the user is administrator
    }
}
