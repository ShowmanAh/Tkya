<?php

namespace App\Http\Controllers\Order;
use Validator;
use App\Cart\Cart;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\ApiResponseTrait;
use App\Rules\ValidShippingMethod;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    use ApiResponseTrait;
    protected $cart;
    public function __construct(){
        $this->middleware(['auth:api']);
      //  $this->cart = $cart;
    }

    public function store(Request $request, Cart $cart){
        // check cart is empty
        if ($cart->isEmpty()) {
             return $this->returnError(400, 'Cart empty');
        }
   // $address = Address::find($request->address_id);
     $rules = [
         // check user_id equal to auth()->user()->id
         'address_id' => ['required',
          Rule::exists('addresses', 'id')->where(function ($query){
             $query->where('user_id', request()->user()->id);
         }),

        ],
        // check if  country_id not changed
        'shipping_method_id' => [
            'required',
            'exists:shipping_methods,id',
            new ValidShippingMethod(request()->address_id)
        ]

     ] ;
     $validator = Validator::make($request->all(), $rules);
     if($validator->fails()){
    // return response()->json([0 , $validator->errors()->first() , $validator->errors()]);
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);

     }
   // dd('a');
     $order =  $this->createOrder($request, $cart);
        $products = $cart->products()->keyBy('id')->map(function ($product){
            return [
                'quantity' => $product->pivot->quantity
            ];
        });
       // dd($products);
       $order->products()->sync($products);

    }
    public function createOrder(Request $request, Cart $cart){
      return $request->user()->orders()->create(
            array_merge( $request->only(['address_id', 'shipping_method_id']), [
                'subtotal' => $cart->subtotal()->amount()
            ])

        );
    }
}
