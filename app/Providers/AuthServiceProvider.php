<?php

namespace App\Providers;

use App\Post;
use App\Policies\{PostPolicy,AdminUserPolicy,AdminBoatPolicy,CommentPolicy};

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Post' => 'App\Policies\PostPolicy',
        'App\User' => 
                        [
                            'App\Policies\AdminUserPolicy',
                            'App\Policies\UserPolicy',
                        ],

        'App\Boat' => 'App\Policies\AdminBoatPolicy',
        'App\Comment' => 'App\Policies\CommentPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('post', 'App\Policies\PostPolicy');
        Gate::resource('adminuser', 'App\Policies\AdminUserPolicy');
        Gate::resource('boat', 'App\Policies\AdminBoatPolicy');
        Gate::resource('comment', 'App\Policies\CommentPolicy');
        Gate::resource('user', 'App\Policies\UserPolicy');

        Gate::define('admin-menu', function ($user) {
            return $user->hasAccess(['administrator']);
        });

        Gate::define('author-menu', function ($user) {
            return $user->hasAccess( ["author","administrator"] );
        });
    }
}
