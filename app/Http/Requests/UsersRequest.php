<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'permission' => ['nullable'],
            'wa_phone' => ['nullable'],
            'brand_name' => ['nullable', 'string', 'min:3', 'max:20'],
            'phone' => ['nullable'],
            'dp' => ['image', 'required_with:save-photo'],
        ];
    }
}
