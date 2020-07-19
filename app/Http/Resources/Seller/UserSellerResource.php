<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSellerResource extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'roles' => $this->getRoleNames(),
        ];
    }
}
