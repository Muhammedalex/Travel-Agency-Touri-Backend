<?php

namespace App\Http\Requests\Booking\Accommodation;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AccTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->user()->can('country create')){return true;}
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
            'type' => [
                'required',
                Rule::unique('accommodation_types', 'type'),
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
