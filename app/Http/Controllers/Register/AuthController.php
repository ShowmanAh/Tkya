<?php

namespace App\Http\Controllers\Register;

use App\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;
use Validator;
class AuthController extends Controller
{
    use ApiResponseTrait;
    public function register(Request $request){
       $rules = [
           'name' => 'required',
           'email' => 'required|unique:users,email',
           'password' => 'required'
       ];
       $validator = Validator::make($request->all(), $rules);
       if($validator->fails()){
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
       }
    $user = User::create($request->only('name', 'email', 'password'));
    $user = new PrivateUserResource($user);
    if(!$user){
        return $this->returnError('E001', 'error ocured');
    }
    return $this->returnData('user', $user, 'register successed');

    }
    public function login(Request $request){
     try {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
         $code = $this->returnCodeAccordingToInput($validator);
         return $this->returnValidationError($code, $validator);
        }
        $credentials = $request->only('email','password');
        $token = auth()->attempt($credentials);
        if(!($token)){
            return $this->returnError('E001', 'data not invalid');
        }
         $user = auth()->user();
         $user = new PrivateUserResource($user);
        return response()->json([
            'status' => true,
            'errNum' => "E000",
            'msg' => 'login successed',
            'user' => $user,
            'meta' => [
                'token' => $token
            ]
            ]) ;

     } catch (Exception $e) {
        return $this->returnError('E001', 'data not invalid');
     }
    }
}
