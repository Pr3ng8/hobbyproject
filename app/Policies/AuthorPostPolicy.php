<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAccess(["administrator","author","user"]); //Check if the user is administrator or author
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(["administrator","author"]); //Check if the user is administrator or author
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        //Check if the user is administrator or author and the post belongs to the current authenticated user
         return $user->hasAccess(["administrator","author"]) && $post->user_id === $user->id ? TRUE : FALSE; 
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        //Check if the user is administrator or author and the post belongs to the current authenticated user
        return $user->hasAccess(["administrator","author"]) && $post->user_id === $user->id ? TRUE : FALSE;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //Check if the user is administrator or author and the post belongs to the current authenticated user
        return $user->hasAccess(["administrator","author"]) && $post->user_id === $user->id ? TRUE : FALSE;
    }

    /**
     * Determine whether the user can edit the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function edit(User $user, Post $post)
    {
        //Check if the user is administrator or author and the post belongs to the current authenticated user
        return $user->hasAccess(["administrator","author"]) && $post->user_id === $user->id ? TRUE : FALSE;
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        return false;
    }
}
