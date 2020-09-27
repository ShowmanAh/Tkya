<?php

use App\Cart\Money;
 namespace App\Cart;
 use App\User;
 class Cart{
      protected $user;
      protected $changed;
  public function __construct(User $user){
     $this->user = $user;
  }
  // add products by user authenticated
  public function add($products){
    $this->user->cart()->syncWithoutDetaching($this->getByLoad($products));

  }
  public function increase($products){
    $this->user->cart()->syncWithoutDetaching($this->getByLoadQuantiity($products));
  }
  // update quantity by productVariationId
  public function update($productId, $quantity){
      $this->user->cart()->updateExistingPivot($productId,[
          'quantity' => $quantity
      ]);

  }
  // delete cart
  public function delete($productId){
      $this->user->cart()->detach($productId);
  }
  // empty Cart
  public function empty(){
      $this->user->cart()->detach();
  }
  // check cart is empty
  public function isEmpty(){
      return $this->user->cart->sum('pivot.quantity') === 0;
  }
  // calc subtotal amount for product
  public function subtotal(){
      $subtotal = $this->user->cart->sum(function($product){
          return $product->price->amount() * $product->pivot->quantity;
      });
      return new Money($subtotal);
  }
  // calc total fpr products
  public function total(){
     return  $this->subtotal();
  }
// check if user quantity > quantity in stock or not if > put user quantity = quantity in stock
  public function sync(){
     
      $this->user->cart->each(function ($product){
        $quantity = $product->minStock($product->pivot->quantity);
       // dd($quantity);
       $this->changed = $quantity != $product->pivot->quantity;
       $product->pivot->update([
           'quantity' => $quantity
       ]);
      });
  }
  // check if quantity value changed or no
  public function hasChanged(){
      return $this->changed;
  }

  // get products
  public function getByLoad($products){
    //$products = $request->products;
    $products = collect($products)->keyBy('id')->map(function($product){
        return [
        'quantity' => $product['quantity']
        ];
    });
    return $products;
  }
  public function getByLoadQuantiity($products){
     //$products = $request->products;

    $products = collect($products)->keyBy('id')->map(function($product){
        return [
        'quantity' => $product['quantity'] + $this->getCurrentQuantity($product['id'])
        ];
    });

    return $products;
  }
  // get current quantity for product
  public function getCurrentQuantity($productId){
      if($product = $this->user->cart->where('id', $productId)->first()){
          return $product->pivot->quantity;
      }
      return 0;
  }
  }
?>
