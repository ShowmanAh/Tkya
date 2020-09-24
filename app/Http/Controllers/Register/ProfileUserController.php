<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;

class ProfileUserController extends Controller
{
    use ApiResponseTrait;
    public function __construct(){
        $this->middleware('auth:api');
    }
   public function me(Request $request){
     // dd($request->user());
    $user = new PrivateUserResource($request->user());
    return $this->returnData('user', $user);

   }
}
