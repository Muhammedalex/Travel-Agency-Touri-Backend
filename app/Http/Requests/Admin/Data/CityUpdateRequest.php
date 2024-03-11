<?php

namespace App\Http\Requests\Admin\Data;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CityUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->user()->can('city edit')){return true;}

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city' => [
                'required',
                Rule::unique('cities', 'city')->ignore($this->route('city')),
            ],
            'country_id' => [
                'required',
                Rule::exists('countries', 'id'),
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Unprocessable Entity',
            'data' => null,
            'status' => 422,
            'status_message' => $validator->errors()->all(),
        ], 422));
    }

    public function response(array $errors)
    {
        // Customize the response for other validation errors, if needed
        return response()->json([
            'success' => false,
            'message' => 'Unprocessable Entity',
            'data' => null,
            'status' => 422,
            'status_message' => $errors['message'] ?? 'Validation failed',
        ], 422);
    }
}
