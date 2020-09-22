<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
//use App\Http\Controllers\Category\CategoriesController;

class CategoriesController extends Controller
{
    public function index(){
        $categories = new CategoryResource(
            Category::with('children')->parents()->ordered()->first()
        );
        return $categories;
         }
}
