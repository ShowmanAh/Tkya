<?php

namespace App\Http\Controllers\Address;
use Validator;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;

class AddressesController extends Controller
{
    use ApiResponseTrait;
    public function __construct(){
       $this->middleware(['auth:api']);
    }
    public function index(Request $request){
       return AddressResource::collection(
           $request->user()->addresses
       );
    }
    public function store(Request $request){
        $rules = [
             'name' => 'required',
             'address_1' => 'required',
             'city' => 'required',
             'postal_code' => 'required',
             'country_id' => 'required|exists:countries,id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
         $code = $this->returnCodeAccordingToInput($validator);
         return $this->returnValidationError($code, $validator);
        }
        $address = Address::make($request->only([
       'name', 'address_1', 'city', 'postal_code', 'country_id', 'default'
        ]));
        $request->user()->addresses()->save($address);
        return new AddressResource($address);
    }
}
