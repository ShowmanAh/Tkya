<?php

namespace App\Http\Controllers\Address;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingMethodResource;

class AddressShipingController extends Controller
{
    use ApiResponseTrait;
    public function __construct(){
        $this->middleware(['auth:api']);
    }
    public function action(Request $request){
        $address = Address::findOrFail($request->id);
        $this->authorize('show', $address);
      // dd($address->country->shippingMethods);
        $shipping = ShippingMethodResource::collection(
            $address->country->shippingMethods
        );
        return $this->returnData('shippingMethods', $shipping, 'successed');
    }
}
