<?php

use App\User;
 namespace App\Cart;
  class Cart{
      protected $user;
  public function __construct(User $user){
     $this->user = $user;
  }
  public function add($products){
    //$products = $request->products;
    $products = collect($products)->keyBy('id')->map(function($product){
      return [
       'quantity' => $product['quantity']
      ];
    });
    //dd($products);
    $this->user->cart()->syncWithoutDetaching($products);

  }
  }
?>
