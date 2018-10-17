<?php

namespace App\Providers;

use App\Post;
use App\Policies\PostPolicy;

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
        'App\User' => 'App\Policies\AdminUserPolicy',
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
        Gate::resource('user', 'App\Policies\AdminUserPolicy');

        Gate::define('admin-menu', function ($user) {
            return $user->hasAccess(['administrator']);
        });

        Gate::define('author-menu', function ($user) {
            return $user->hasAccess( ["author","administrator"] );
        });
    }
}
