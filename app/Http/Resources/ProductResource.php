<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductVariationsResource;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //dd($this->variations->groupBy('type.name'));
        // group by return empty result set strict => false in config/database
        return array_merge(parent::toArray($request), [
            'variations' => ProductVariationsResource::collection(
                $this->variations->groupBy('type.name'),
                )
        ]);
    }
}
