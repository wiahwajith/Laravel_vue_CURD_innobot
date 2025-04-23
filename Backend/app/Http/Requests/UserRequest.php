<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|numeric',
            'address' => 'nullable|string',
            'age' => 'nullable|numeric|min:0|max:150',
            'profile_picture' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'phone_number.numeric' => 'Phone number must be numeric.',
            'age.numeric' => 'Age must be a number.',
            'profile_picture.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
            'profile_picture.max' => 'Profile picture must not exceed 2MB.',
        ];
    }
}
