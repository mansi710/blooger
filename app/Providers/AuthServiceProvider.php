<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin',function($user)
        {
            if($user->role==='admin')
            {
                return true;
            }
            else
            {
                return false;
            }
        });

        Gate::define('isUser',function($user)
        {
            if($user->role==='user')
            {
                return true;
            }
            else
            {
                return false;
            }
        });
        //
    }
}
