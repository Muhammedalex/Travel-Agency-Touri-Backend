<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => 'sometimes|max:50',
            'last_name' => 'sometimes|max:50',
            'mobile' => 'sometimes|digits_between:11,20|unique:users,mobile,'.$this->user()->id,
            'email' => 'sometimes|unique:users,email,'.$this->user()->id,
            'role_id' => 'sometimes|exists:roles,id', // Assuming roles table exists
            'country_id' => 'sometimes|exists:countries,id', // Assuming countries table exists
            'photo'=>['image'],
        ];
    }
}
