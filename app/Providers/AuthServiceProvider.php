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
        'App\Post' => [
                        'App\Policies\AuthorPostPolicy',
                        'App\Policies\AdminPostPolicy'
                        ],
        'App\User' => [
                        'App\Policies\AdminUserPolicy',
                        'App\Policies\UserPolicy'
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

        Gate::resource('post', 'App\Policies\AuthorPostPolicy', [
            'restore' => 'restore'
        ]);

        Gate::resource('admin-post', 'App\Policies\AdminPostPolicy', [
            'restore' => 'restore',
            'edit'    => 'edit'
        ]);
        
        Gate::resource('admin-user', 'App\Policies\AdminUserPolicy');

        Gate::resource('boat', 'App\Policies\AdminBoatPolicy');
        Gate::resource('comment', 'App\Policies\CommentPolicy');

        Gate::define('user.view', 'App\Policies\UserPolicy@view');
        Gate::define('user.edit', 'App\Policies\UserPolicy@edit');
        Gate::define('user.update', 'App\Policies\UserPolicy@update');


        Gate::define('admin-menu', function ($user) {
            return $user->hasAccess(['administrator']);
        });

        Gate::define('author-menu', function ($user) {
            return $user->hasAccess( ["author","administrator"] );
        });
    }
}
