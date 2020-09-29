<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'card_type',
        'last_four',
        'provider_id',
        'default'
    ];
    public static function boot(){
        parent::boot();
        static::creating(function($paymentMethod){
           //  dd($address);
           if($paymentMethod->default){
               $paymentMethod->user->paymentMethods()->update([
                   'default' => false
               ]);
           }
        });
    }
      // set default with true if val  = true or if exists val true or false if not false
      public function setDefaultAttribute($value){
        $this->attributes['default'] = ($value === 'true' || $value ? true : false);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
