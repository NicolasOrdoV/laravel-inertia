<?php

namespace App\Providers;

use App\Models\ShoppingCart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

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
        Event::listen(function (Login $event) {
            $this->setShoppingCartSession();
        });
    }

    private function setShoppingCartSession()
    {
        $cartDb = ShoppingCart::where('user_id', Auth::id())->get();
        $cartSession = session('cart', []);
        foreach($cartDb as $c) {
            if (Arr::exist($$cartSession, $c->post->id)) {
                //update
                $$cartSession[$c->post->id][1] = $c->count;
            } else {
                //add
                $$cartSession[$c->post->id] = [$c->post, $c->count];
            }

            session(['cart' => $cartSession]);
        }
    }
}
