<?php

namespace App\Http\Requests\Course;

use App\Services\ApiResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCourseRequest extends FormRequest
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
            'title' => $this->title ? ucwords(trim($this->title)) : null,
            'start_date' => $this->start_date ? date('Y-m-d', strtotime($this->start_date)) : null,
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
            'title' => 'nullable|string|max:100|min:5',
            'description' => 'nullable|string|max:255',
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'instructors' => 'nullable|array',
            'instructors.*' => 'exists:instructors,id',
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
            'title' => 'course title',
            'description' => 'course description',
            'start_date' => 'course start date',
            'instructors' => 'instructors',
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
            'date_format' => 'The :attribute must be in the format YYYY-MM-DD.',
            'date' => 'The :attribute must be a valid date.',
            'instructors.*.exists' => 'The selected instructor(s) are invalid.',
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
