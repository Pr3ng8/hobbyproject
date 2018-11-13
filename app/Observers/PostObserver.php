<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    /**
     * Handle the Post "deleting" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function deleting(Post $post)
    {
        //Check if the post has any comment(s)
        if ( $post->comments()->exists() ) {
            //Delete all comment(s) that belongs to the post
            $post->comments()->delete();

        }

        //Check if the post has any photo(s)
        if ( $post->photos()->exists() ) {
            //Delete all photo(s) that belongs to the post
            $post->photos()->delete();

        }
    }

    /**
     * Handle the Post "restoring" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function restoring(Post $post)
    {
        
        //Check if the post has any comment(s)
        if ( $post->comments()->exists() ) {
            //Restore all comment(s) that belongs to the post
            $post->comments()->restore();

        }

        //Check if the post has any photo(s)
        if ( $post->photos()->exists() ) {
            //Restore all photo(s) that belongs to the post
            $post->photos()->restore();

        }
    }

}