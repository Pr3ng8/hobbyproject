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
        if ($user->hasAccess() === "administrator") {
            return true;
        } 
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user)
    {
        if ($user->hasAccess() === "administrator") {
            return true;
        } 
        return false;
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
        if ($user->hasAccess() === "administrator") {
            return true;
        } 
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if ($user->hasAccess() === "administrator") {
            return true;
        } 
        return false;
    }
}
