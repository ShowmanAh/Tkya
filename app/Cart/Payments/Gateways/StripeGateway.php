<?php
namespace App\Cart\Payments\Gateways;
use App\User;
use App\Cart\Payments\Gateway;
use App\Cart\Payments\Gateways\StipeGatewayCustomer;

class StripeGateway implements Gateway{
    public $user;
    public function withUser(User $user){
     $this->user = $user;
     //dd($user);
     return $this;
    }
    public function createCustomer(){
      return new StipeGatewayCustomer();
    }
}


?>
