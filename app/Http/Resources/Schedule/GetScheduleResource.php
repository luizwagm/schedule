<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this?->id,
            "title" => $this?->title,
            "description" => $this?->description,
            "type" => $this?->type,
            "status" => $this?->status,
            "start_date" => $this?->start_date,
            "end_date" => $this?->end_date,
            "user" => $this?->user?->fullname,
            "email" => $this?->user?->email,
        ];
    }
}
