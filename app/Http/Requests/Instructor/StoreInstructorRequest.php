<?php

namespace App\Http\Requests\Instructor;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInstructorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * This method is called before validation starts to clean or normalize inputs.
     * 
     * Capitalize the first letter and trim white spaces if provided
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name ? ucwords(trim($this->name)) : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|min:3',
            'experience' => 'required|integer',
            'specialty' => 'required|string|max:100|min:3',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ];
    }

    /**
     * Custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'instructor name',
            'experience' => 'instructor experience',
            'specialty' => 'instructor specialty',
            'courses' => 'courses',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute is required.',
            'min' => 'The :attribute must be at least :min characters.',
            'max' => 'The :attribute cannot exceed :max characters.',
            'integer' => 'The :attribute must be an integer.',
            'courses.*.exists' => 'The selected courses(s) are invalid.',
        ];
    }

    /**
     * Handle validation errors and throw an exception.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            ApiResponseService::error($errors, 'An error occurred on the server', 422)
        );
    }
}
