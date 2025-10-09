<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
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
            'otp' => ['required'],
            'voter_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => 'OTP is required',
        ];
    }
}
