<?php

namespace App\Policies;

use App\User;
use App\Boat;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminBoatPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the boat.
     *
     * @param  \App\User  $user
     * @param  \App\Boat  $boat
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAccess(['administrator']);
    }

    /**
     * Determine whether the user can create boats.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['administrator']);
    }

    /**
     * Determine whether the user can update the boat.
     *
     * @param  \App\User  $user
     * @param  \App\Boat  $boat
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasAccess(['administrator']);
    }

    /**
     * Determine whether the user can delete the boat.
     *
     * @param  \App\User  $user
     * @param  \App\Boat  $boat
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasAccess(['administrator']);
    }
}
