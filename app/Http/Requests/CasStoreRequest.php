<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CasStoreRequest extends FormRequest
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
            "assignment_name" => ["required", "string", "max:100"],
            "date_assigned" => ["required", "date"],
            "full_marks" => ["required", "numeric", "min:0"],
            "cas_type" => ["required", "exists:cas_types,id"],
            "students" => ["array", "exists:students,id"],
            "marks" => ["array", "min:0"],
        ];
    }

    public function messages(): array
    {
        return [
            "assignment_name.required" => "Assignment name is required",
            "assignment_name.string" => "Assignment name must be a string",
            "assignment_name.max" => "Assignment name must not exceed 100 characters",
            "date_assigned.required" => "Assignment date is required",
            "date_assigned.date" => "Assignment date must be a valid date",
            "full_marks.required" => "Full marks is required",
            "full_marks.numeric" => "Full marks must be a number",
            "full_marks.min" => "Full marks must be greater than or equal to 0",
            "cas_type.required" => "CAS type is required",
            "cas_type.exists" => "CAS type does not exist",
            "students.exists" => "One or more students do not exist",
            "marks.min" => "Marks must have at least 1 element",
        ];
    }
}
