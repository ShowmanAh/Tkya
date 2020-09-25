<?php

namespace App\Http\Controllers\Cart;
use Validator;
use App\Cart\Cart;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    use ApiResponseTrait;
    protected $cart;
    public function __construct(Cart $cart){
         $this->middleware(['auth:api']);
         $this->cart = $cart;
    }
    // user add product to cart with quantity
    public function store(Request $request){
     // dd($request->products);
        $rules = [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:product_variations,id',
            'products.*.quantity' => 'numeric|min:1',

        ];
        $validator = Validator::make($request->all(), $rules);
       if($validator->fails()){
      // return response()->json([0 , $validator->errors()->first() , $validator->errors()]);
      $code = $this->returnCodeAccordingToInput($validator);
      return $this->returnValidationError($code, $validator);

       }
        $products = $request->products;
         $this->cart->add($products);
    }

    public function increaseQuantity(Request $request){
        $rules = [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:product_variations,id',
            'products.*.quantity' => 'numeric|min:1',

        ];
        $validator = Validator::make($request->all(), $rules);
       if($validator->fails()){
      // return response()->json([0 , $validator->errors()->first() , $validator->errors()]);
          $code = $this->returnCodeAccordingToInput($validator);
          return $this->returnValidationError($code, $validator);

       }
        $products = $request->products;
         $this->cart->increase($products);

    }
    // update quantity by productVariationId
    public function update(Request $request, Cart $cart){
        $rules = [
           'quantity' => 'required|numeric|min:3'
        ];
        $validator = Validator::make($request->all(), $rules);
       if($validator->fails()){
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
       }
      $productVariation = ProductVariation::findOrFail($request->id);
     // dd($productVariation->id);
       $this->cart->update($productVariation->id, $request->quantity);
    }

}