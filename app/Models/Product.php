<?php

namespace App\Models;
use App\Traits\hasPriceTrait;
use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use hasPriceTrait;
    public function getRouteKeyName(){
        return 'slug';
    }
     // check stock countproduct_variation  > 0 return true
     public function inStock(){

        return $this->stockCount() > 0;
    }
    // get count product_variation in stock
    public function stockCount(){
        return $this->variations->sum(function($variation){
            return $variation->stockCount();
        });
    }

    public function scopeWithScopes(Builder $builder, $scopes = []){
         return (new Scoper(request()))->apply($builder, $scopes);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id');
    }
    public function variations(){
       return $this->hasMany(ProductVariation::class)->orderBy('order', 'asc');
    }
}
