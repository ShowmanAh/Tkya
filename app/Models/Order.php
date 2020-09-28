<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const PAYMENT_FAILED = 'payment_failed';
    const COMPLETED = 'completed';
    protected $fillable = [
      'address_id',
      'shipping_method_id',
      'status'
    ];
    public static function boot(){
        parent::boot();
        static::creating(function ($order){
           $order->status = self::PENDING;
        });
    }
    public function user(){
       return $this->belongsTo(User::class);
    }
    public function address(){
        return $this->belongsTo(Address::class);
     }
     public function shippingMethod(){
        return $this->belongsTo(shippingMethod::class);
     }
}
