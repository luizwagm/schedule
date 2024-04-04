<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this?->id,
            "fullname" => $this?->fullname,
            "email" => $this?->email,
            "created_at" => $this?->created_at,
        ];
    }
}
