<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubCategoryResource;

class CategoriesController extends Controller
{
    use ApiResponseTrait;
   public function Maincategories(){
      $categories = CategoryResource::collection(
            Category::parents()->ordered()->get()
        );
       // return $categories;
       return $this->returnData('MainCategories', $categories);
     }

     public function subCategories(){
         $categories =
             Category::with('children')->parents()->ordered()->get();


         foreach ($categories as  $cat) {
             if ($cat) {
                // return $cat['children'];
                $subCtegories = SubCategoryResource::collection(($cat['children']));
               // return $subCtegories;
               return $this->returnData('subCategories', $subCtegories);
             }

         }
     }
     public function categoryWithChildren(){
         $categories = CategoryResource::collection(
             Category::with('children')->parents()->ordered()->get()
         );
        // return $categories;
       return $this->returnData('categories', $categories);
     }
}
