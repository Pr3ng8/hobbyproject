<?php

namespace App\Providers;

use App\Post;
use App\Observers\PostObserver;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
