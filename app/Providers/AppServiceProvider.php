<?php
namespace App\Providers;
use App\Cart\Cart;
use Stripe\Stripe;
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
        // register Cart Class
          $this->app->singleton(Cart::class, function($app){
              if($app->auth->user()){
                 $app->auth->user()->load([
                   'cart.stock'
                 ]);
              }
           return new Cart($app->auth->user());
          });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
}
