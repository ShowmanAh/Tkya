<?php

namespace App\Http\Resources;

use App\Cart\Money;
use App\Http\Resources\ProductIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
           'product'=> new ProductIndexResource($this->product),
           'quantity' => $this->pivot->quantity,
           'total' => $this->totalPrice()->formatted(),
        ]);
    }
    public function totalPrice(){
        $total = new Money($this->pivot->quantity * $this->price->amount());
        return $total;
    }
}
