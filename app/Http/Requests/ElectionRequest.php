<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'election_name' => ['required', 'string', 'max:255'],
            'election_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'after_or_equal:now'],
            'end_time' => ['required', 'after:start_time'],
            'candidates' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'election_name.required' => 'The election name is required.',
            'election_date.required' => 'The election date is required.',
            'election_date.after_or_equal' => 'The election date must be today or a future date.',
            'start_time.required' => 'The start time is required.',
            'start_time.after_or_equal' => 'The start time must be a date and time after or equal to now.',
            'end_time.required' => 'The end time is required.',
            'end_time.after' => 'The end time must be a date and time after the start time.',
            'candidates.required' => 'Please select at least one candidate.',
        ];
    }
}
