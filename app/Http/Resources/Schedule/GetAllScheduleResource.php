<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->map(function ($res) {
            return [
                "id" => $res?->id,
                "title" => $res?->title,
                "description" => $res?->description,
                "type" => $res?->type,
                "status" => $res?->status,
                "start_date" => $res?->start_date,
                "end_date" => $res?->end_date,
                "user" => $res?->user?->fullname,
                "email" => $res?->user?->email,
            ];
        })->toArray();
    }
}
