<?php
namespace App\Cart;
use Money\Currency;
use NumberFormatter;
use Money\Money as BaseMoney;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

class Money{
    protected $money;
    public function __construct($value){
        $this->money = new BaseMoney($value, new Currency('GBP'));
    }
    // return price formatted
    public function formatted(){
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_GP', NumberFormatter::CURRENCY),
            new ISOCurrencies()
         );
         return $formatter->format($this->money);

    }
    // return price amount
    public function amount(){
        return $this->money->getAmount();
    }
    // taxes for delivery
    public function add(Money $money){
     $this->money = $this->money->add($money->insstance());
     return $this;
    }
    public function insstance(){
        return $this->money;
    }
}


?>
