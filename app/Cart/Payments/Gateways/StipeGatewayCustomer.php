<?php
namespace App\Cart\Payments\Gateways;

use App\Models\PaymentMethod;
use App\Cart\Payments\Gatewaycustomer;


class StipeGatewayCustomer implements Gatewaycustomer{
    public function charge(PaymentMethod $card, $amount){

    }
    public function addCard($token){
      dd('add card');
    }
}


?>
