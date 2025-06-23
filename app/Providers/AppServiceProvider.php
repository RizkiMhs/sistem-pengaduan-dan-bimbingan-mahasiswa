<?php

namespace App\Providers;

// use Illuminate\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::define('admin', function (User $user) {
            return $user->role === 'kaprodi';
        });

        Gate::define('dosen_pa', function (User $user) {
            return $user->role === 'dosenpa';
        });

        Gate::define('mahasiswa', function (User $user) {
            return $user->role === 'mahasiswa';
        });

    }
}
