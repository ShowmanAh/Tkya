<?php

namespace App\Http\Resources;

//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //Property [id] does not exist on this collection instance. in file
        if ($this->resource instanceof Collection) {
            return ProductVariationsResource::collection($this->resource);
        }
        return [
           'id' => $this->id,
           'name' => $this->name,
           'price' => $this->formattedPrice,
           'priceVaries' => $this->PriceVaries(),
           'stockCount' => (int) $this->stockCount(),
           'Type' => $this->type->name,
           'inStock' => $this->inStock()
        ];
    }
}
