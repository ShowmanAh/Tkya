<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Cart\Payments\Gateway;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Cart\Payments\Gateways\StripeGateway;


class PaymentMethodController extends Controller
{
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
        $gateway = new StripeGateway();
    //dd($gateway);
      $card = $gateway->withUser($request->user())
      ->createCustomer()
      ->addCard($request->token);
    //dd($card);
     // dd('a');

    }
}
