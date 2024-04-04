<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => '',
            'end_date' => 'required_with:start_date',
            'title' => '',
            'type' => '',
            'description' => '',
            'status' => 'in:open,concluded',
        ];
    }
}
