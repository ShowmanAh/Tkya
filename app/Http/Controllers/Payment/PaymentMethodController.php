<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Cart\Payments\Gateway;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Cart\Payments\Gateways\StripeGateway;
use Validator;

class PaymentMethodController extends Controller
{
    use ApiResponseTrait;
    protected $gateway;
    public function __constuct(){
        $this->middleware(['auth:api']);
       $this->gateway = $gateway;

    }
    public function index(Request $request){
        $paymentMethods = PaymentResource::collection($request->user()->paymentMethods);
        return $paymentMethods;
         //dd($request->user()->paymentMethods);
    }
    public function store(Request $request){
      //  dd($request->user());
      $rules = [
              'token' => 'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
       $code = $this->returnCodeAccordingToInput($validator);
       return $this->returnValidationError($code, $validator);
      }
        $gateway = new StripeGateway();
    //dd($gateway);
      $card = $gateway->withUser($request->user())
      ->createCustomer()
      ->addCard($request->token);
   // dd($card);
   $card = new PaymentResource($card);
    //dd($card);
   return $this->returnData('Card', $card, 'successed');


    }
}
