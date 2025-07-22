<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // user
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'exists:roles,id'],
            // profile
            'username' => ['required', 'string', 'max:255'],
            'display_name' => ['required', 'string', 'max:255'],
            'prefix' => ['string'],
            'firstname' => ['required', 'string', 'min:3', 'max:50'],
            'middlename' => ['required', 'string', 'min:3', 'max:50'],
            'lastname' => ['required', 'string', 'min:3', 'max:50'],
            'suffix' => ['string'],
            'name' => ['required', 'json', 'max:1000'],
            'gender' => ['required', 'string', 'in:male,female,other'],
            'designation' => ['required', 'string', 'max:255'],
            'photo_id' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['required', 'string'],
        ];
    }
}
