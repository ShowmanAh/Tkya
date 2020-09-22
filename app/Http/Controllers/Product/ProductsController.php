<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\CategoryScope;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductIndexResource;

class ProductsController extends Controller
{
  public function index(){
      $products = Product::withScopes($this->scopes())->paginate(10);
      return ProductIndexResource::collection($products);
  }
  public function show($slug){
        $product = Product::where('slug', $slug)->first();
        return new ProductResource($product);
       // dd($product);
       // return $product;
  }

  public function scopes(){
      return [
          'category' => new CategoryScope(),
      ];
  }
}
