<?php

namespace App\Http\Controllers\Cart;
use Validator;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    use ApiResponseTrait;
    public function __construct(){
         $this->middleware(['auth:api']);

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
       return response()->json([0 , $validator->errors()->first() , $validator->errors()]);
       }
        $products = $request->products;
        $products = collect($products)->keyBy('id')->map(function($product){
          return [
           'quantity' => $product['quantity']
          ];
        });
       // dd($products);
        $request->user()->cart()->syncWithoutDetaching($products);
      ;
    }
}
