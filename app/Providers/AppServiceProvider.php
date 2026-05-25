<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Pagination\Paginator::useBootstrap();

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (auth()->check()) {
                $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                $cartCount = $cart ? \App\Models\CartItem::where('cart_id', $cart->id)->count() : 0;
                
                $unreadNotesCount = \App\Models\Transaction::where('user_id', auth()->id())
                    ->whereNotNull('admin_note')
                    ->where('is_note_read', false)
                    ->count();

                $notifications = \App\Models\Transaction::where('user_id', auth()->id())
                    ->whereNotNull('admin_note')
                    ->latest()
                    ->take(5)
                    ->get();

                $view->with([
                    'cartCount' => $cartCount,
                    'unreadNotesCount' => $unreadNotesCount,
                    'notifications' => $notifications
                ]);
            } else {
                $view->with([
                    'cartCount' => 0,
                    'unreadNotesCount' => 0,
                    'notifications' => collect()
                ]);
            }
        });
    }
}
