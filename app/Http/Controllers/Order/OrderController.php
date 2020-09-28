<?php

namespace App\Http\Controllers\Order;
use App\Models\Address;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Traits\ApiResponseTrait;
use App\Rules\ValidShippingMethod;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    use ApiResponseTrait;
    public function __construct(){
        $this->middleware(['auth:api']);
    }

    public function store(Request $request){
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
    dd('a');
    }
}
