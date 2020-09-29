<?php
namespace App\Traits;
Trait canBeDefault{
  // check if exist default make update previouse with false
  public static function boot(){
    parent::boot();
    static::creating(function($address){
       //  dd($address);
       if($address->default){
           $address->newQuery()->where('user_id', $address->user->id)->update([
            'default' => false
           ]);
          // $address->user->addresses()->update([ 'default' => false   ]);
       }
    });
}
// set default with true if val  = true or if exists val true or false if not false
public function setDefaultAttribute($value){
    $this->attributes['default'] = ($value === 'true' || $value ? true : false);
}
}
?>
