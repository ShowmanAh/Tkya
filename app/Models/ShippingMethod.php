<?php

namespace App\Models;

use App\Traits\hasPriceTrait;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use hasPriceTrait;
    public function countries(){
        return $this->belongsToMany(Country::class);
    }
}
