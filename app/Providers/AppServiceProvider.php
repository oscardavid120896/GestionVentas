<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\User;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $this->register();
        URL::forceScheme('https');

        Gate::define('alumno', function ($user) {
            if ($user->rol == 'directivo') {
                return true;
            }
            return false;
        });
        Gate::define('profesor', function ($user) {
            if ($user->rol == 'directivo') {
                return true;
            }
            return false;
        });
        Gate::define('gestion', function ($user) {
            if ($user->rol == 'directivo') {
                return true;
            }
            return false;
        });   

    }
}
