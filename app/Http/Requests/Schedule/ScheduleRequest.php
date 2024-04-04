<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => 'required',
            'end_date' => 'required',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            'status' => 'in:open,concluded',
        ];
    }
}
