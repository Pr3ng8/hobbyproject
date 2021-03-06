<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAccess(['administrator','author','user']); //Chek if the user is administrator, author or simple user
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['administrator','author','user']); //Chek if the user is administrator, author or simple user
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        //Chek if the user is administrator, author or simple user and the comment belongs to the currently authenticated user
        return $user->hasAccess(['administrator','author','user']) && $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        //Chek if the user is administrator, author or simple user and the comment belongs to the currently authenticated user
        return $user->hasAccess(['administrator','author','user']) && $comment->user_id === $user->id;
    }
}
