<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreatedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $arrReturn = [
            "fullname" => $this->fullname,
            "document" => $this->document,
            "document_type" => $this->document_type,
            "email" => $this->email,
            "phone" => $this->phone,
            "user_type" => $this->user_type
        ];

        if ($this->document_type == User::DOCUMENT_TYPE_CNPJ) {
            $arrReturn['company_name'] = $this->company_name;
            $arrReturn['state_registration'] = $this->state_registration;
        }

        $arrReturn['created_at'] = $this->created_at;

        return $arrReturn;
    }
}
