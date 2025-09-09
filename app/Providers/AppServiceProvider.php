<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

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
        // Share fineCount with all views for authenticated users
        View::composer('*', function ($view) {
            $fineCount = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $fineCount = Borrowing::where('user_id', $user->id)
                    ->where('fine_amount', '>', 0)
                    ->where('fine_paid', false)
                    ->count();
            }
            $view->with('fineCount', $fineCount);
        });
    }
}
