<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  int  $id
     * @return mixed
     */
    public function view(User $user, int $id)
    {
        return $user->id === $id;
    }

    /**
     * Determine whether the user can edit models.
     *
     * @param  \App\User  $user
     * @param  int  $id
     * @return mixed
     */
    public function edit(User $user, int $id)
    {
        return $user->id === $id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  int  $id
     * @return mixed
     */
    public function update(User $user, int $id)
    {
        return $user->id === $id;
    }
}
