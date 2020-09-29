<?php

namespace App\Http\Middleware\Cart;

use Closure;
use App\Cart\Cart;

class Sync
{
    protected $cart;
    public function __construct(Cart $cart){
        $this->cart = $cart;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->cart->sync();
        if ($this->cart->hasChanged()) {
            return response()->json([
            'message' => 'some items in this cart has changed, please review changes before you place order'
            ], 409);
        }
        return $next($request);
    }
}
