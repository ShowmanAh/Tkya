<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;

class PaymentMethodController extends Controller
{
    public function __constuct(){
        $this->middleware(['auth:api']);
    }
    public function index(Request $request){
        $paymentMethods = PaymentResource::collection($request->user()->paymentMethods);
        return $paymentMethods;
         //dd($request->user()->paymentMethods);
    }
}
