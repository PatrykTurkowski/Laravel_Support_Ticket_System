<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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

        Gate::resource('users', 'App\Policies\UserPolicy');
        Gate::resource('categories', 'App\Policies\CategoryPolicy');
        Gate::resource('labels', 'App\Policies\LabelPolicy');
        Gate::resource('tickets', 'App\Policies\ticket');
        Gate::before(function ($user, $ability) {
            if ($user->role == RoleEnum::ADMIN->value) {
                return true;
            }
        });
    }
}