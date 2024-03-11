<?php

namespace App\Http\Requests\Admin\Employees;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
class DriverUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->user()->can('country create')){return true;}
        return false;    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
            ],
            'mobile' => 'sometimes|unique:users,mobile|digits_between:11,20',
            'car_model' => [
                'sometimes',  
            ],
            'num_of_seats' => [
                'sometimes', 
                'integer', 
            ],
            'driver_rate' => [
                'sometimes', 
                'integer', 
            ],
            'driver_price' => [
                'sometimes', 
                'integer', 
            ],
            'note' => [
                'sometimes', 
                'max:200'
            ],
            'share' => [
                'sometimes', 
                'integer', 
            ],
            'picture'=>[
                'sometimes',
                'image'
            ],
            'city_id'=>[
                'sometimes',
                Rule::exists('cities', 'id'),
            ],
            'transportation_id' => 'sometimes|exists:transportations,id',
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
