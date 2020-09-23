<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    // tupe has many variation and varition has one type
    public function type(){
        return $this->hasOne(ProductVariationType::class,'id', 'product_variation_type_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
