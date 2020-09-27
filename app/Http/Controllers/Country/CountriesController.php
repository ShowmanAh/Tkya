<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountriesResource;

class CountriesController extends Controller
{
  use ApiResponseTrait;
   public function __construct(){
       $this->middleware(['auth:api']);
   }
   public function index(){
     $countries = CountriesResource::collection(
         Country::get()
     );
    return $this->returnData('countries', $countries, 'successed');
   }
}
