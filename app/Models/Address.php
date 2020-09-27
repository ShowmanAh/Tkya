<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Address extends Model
{
    protected $fillable = ['name', 'address_1', 'city', 'postal_code', 'country_id', 'default'];
    // check if exist default make update previouse with false
    public static function boot(){
        parent::boot();
        static::creating(function($address){
           //  dd($address);
           if($address->default){
               $address->user->addresses()->update([
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
    public function country(){
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}

