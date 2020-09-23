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
