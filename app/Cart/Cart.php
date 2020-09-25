<?php
 namespace App\Cart;
 use App\User;
 class Cart{
      protected $user;
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
