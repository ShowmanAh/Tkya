<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'order', 'parent_id'];
    public function scopeParents(Builder $builder){
        return $builder->whereNull('parent_id');
    }
    public function scopeOrdered(Builder $builder, $direction = 'desc'){
        return $builder->orderBy('order', $direction);
    }
    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'categories_products', 'category_id', 'product_id');
    }

}
