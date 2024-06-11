<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherCasStoreRequest extends FormRequest
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
            //
            "assignment_name" => ["required", "string", "max:100"],
            "date_assigned" => ["required", "date"],
            "cas_type" => ["required", "exists:cas_types,id"],
            "students" => ["required", "exists:students,id"],
            "marks" => ["array", "min:0"],
        ];
    }

    public function messages()
    {
        return [
            "assignment_name.required" => "Assignment name is required",
            "assignment_name.string" => "Assignment name must be a string",
            "assignment_name.max" => "Assignment name must be at most 100 characters",
            "date_assigned.required" => "Assignment date is required",
            "date_assigned.date" => "Assignment date must be a valid date",
            "cas_type.required" => "CAS type is required",
            "cas_type.exists" => "CAS type does not exist",
            "students.required" => "Students are required",
            "students.exists" => "One or more students do not exist",
            "marks.array" => "Marks must be an array",
            "marks.min" => "Marks must have at least 0 elements",
        ];
    }
}
