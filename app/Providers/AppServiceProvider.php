<?php

namespace App\Providers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

use Auth;
use App\Models\Palette_color;

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
    public function boot()
    {
        //
        if($this->app->environment('producction')) {
            URL::forceScheme('https');
        }

        view()->composer('*', function (View $view) {
            $palette_colors = Palette_color::where([
                ["active","=",1],
                ["user_id","=",( Auth::user() ) ? Auth::user()->id : 0],
            ])->first();

            $view->with('palette_colors', $palette_colors);
        });
    }
}
