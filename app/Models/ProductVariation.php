<?php

namespace App\Models;

use App\Cart\Money;
use App\Traits\hasPriceTrait;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use hasPriceTrait;
    // check if product variation price == null put product price (parent) in sub (product variations price)
    public function getPriceAttribute($value){
        if($value === null){
            return $this->product->price;
        }
        return new Money($value);
    }

    public function minStock($count){
        return min($this->stockCount(), $count);
    }
    // check if product variation pric enot equal  product price return true else false
    public function PriceVaries(){
        return $this->price->amount() != $this->product->price->amount();
    }
    // check stock countproduct_variation  > 0 return true
    public function inStock(){
        //return (bool) $this->stock->first()->pivot->in_stock;
        return $this->stockCount() > 0;
    }
    // get count product_variation in stock
    public function stockCount(){

        return $this->stock->sum('pivot.stock');
    }
    // tupe has many variation and varition has one type
    public function type(){
        return $this->hasOne(ProductVariationType::class,'id', 'product_variation_type_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function stocks(){
        return $this->hasMany(Stock::class);
    }
    public function stock(){
        return $this->belongsToMany(ProductVariation::class, 'product_variation_stock_view')
        ->withPivot(
           [
             'stock',
            'in_stocks'
            ]
        );
    }
}
