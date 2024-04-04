<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "fullname" => $this->fullname,
            "document" => $this->document,
            "email" => $this->email,
            "user_type" => $this->user_type,
            "wallet_id" => $this->wallet->id,
            "wallet_amount" => $this->wallet->amount,
        ];
    }
}
