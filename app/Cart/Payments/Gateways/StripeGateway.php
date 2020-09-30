<?php
namespace App\Cart\Payments\Gateways;
use App\User;
use App\Cart\Payments\Gateway;
use App\Cart\Payments\Gateways\StipeGatewayCustomer;
use Stripe\Customer as StripeCustomer;

class StripeGateway implements Gateway{
    public $user;
    public function withUser(User $user){
     $this->user = $user;
     //dd($user);
     return $this; // return gateway
    }
    public function user(){
        return $this->user;// return user
    }
    public function createCustomer(){
        if($this->user->gateway_customer_id){
           // return 'customer';
           return $this->getCustomer();
        }
       $customer = new StipeGatewayCustomer($this, $this->createStripeCustomer());
       $this->user->update([
           'gateway_customer_id' => $customer->id()
       ]);
       return $customer;
      // dd($customer);
     // return new StipeGatewayCustomer();
    }
    protected function getCustomer(){
        return new StipeGatewayCustomer(
            $this, StripeCustomer::retrieve($this->user->gateway_customer_id)
        );
    }
    public function createStripeCustomer(){
        return StripeCustomer::create([
           'email' => $this->user->email
        ]);
    }
}


?>
