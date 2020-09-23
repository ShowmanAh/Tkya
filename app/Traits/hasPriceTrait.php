<?php
namespace App\Traits; 
use App\Cart\Money;
Trait hasPriceTrait{
    public function getPriceAttribute($value){
        return new Money($value);
    }
    public function getFormattedPriceAttribute(){
       return $this->price->formatted();
    }
}

?>
