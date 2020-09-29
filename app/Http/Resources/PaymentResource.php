<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id' => $this->id,
           'card_type' => $this->card_type,
           'last_four' => $this->last_four,
           'provider_id' => $this->provider_id,
           'default' => $this->getDefault()
        ];
    }
    protected function getDefault(){
        return $this->default === 1 ? true :false;
    }
}
