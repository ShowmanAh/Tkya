<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Scoping\Scopes\CategoryScope;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductIndexResource;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function getproducts(){
        $products = ProductIndexResource::collection(Product::paginate($this->paginate_number));
        if($products){
            return $this->returnData('products', $products);
        }
    }
    // get products by category
  public function getProductByCategory(){
      $products = ProductIndexResource::collection(Product::withScopes($this->scopes())->paginate(10));
     if($products){
         return $this->returnData('products', $products);
     }
  }
  // get products with products variation by category
  public function getproductswithVariationsByCategory(){
    $products = ProductResource::collection(
        Product::withScopes($this->scopes())->paginate(10)
    );
    return $this->returnData('products', $products);

  }
 // get product with product variation by slug
  public function show(Request $request){
      try {
        $product = new ProductResource(Product::where('slug', $request->slug)->firstOrFail());
       // return $product;
        if(!$product){
            return $this->returnError('E001', 'product not found');
        }
        return $this->returnData('product', $product);
       // return new ProductResource($product);
      } catch (Exception $ex) {
        return $this->returnError('E001', 'product not found');
      }
  }
  // get product by ID
  public function getProductById(Request $request){
    try {
        $product = new ProductIndexResource(Product::findOrFail($request->id));
        if(!$product){
            return $this->returnError('E001', 'product not found');
        }
        return $this->returnData('product', $product);
       // return new ProductResource($product);
      } catch (Exception $ex) {
        return $this->returnError('E001', 'product not found');
      }
  }
  public function scopes(){
      return [
          'category' => new CategoryScope(),
      ];
  }
}
