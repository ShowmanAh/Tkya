<?php
namespace App\Cart\Payments;

use App\Models\PaymentMethod;

interface Gatewaycustomer{
    public function charge(PaymentMethod $card, $amount);
    public function addCard($token);
}

?>
