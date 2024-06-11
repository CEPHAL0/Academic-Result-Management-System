<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CasRequest extends FormRequest
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
            "student_id" => ["required", "exists:students,id"],
            "assignment_id" => ["required", "exists:assignments,id"],
            "mark" => ["required", "numeric"],
            "remarks" => ["required"],
            "date_assigned" => ["required", "date"]
        ];
    }

    public function messages()
    {
        return [
            "student_id.required" => "Student is required",
            "student_id.exists" => "Student does not exist",
            "assignment_id.required" => "Assignment is required",
            "assignment_id.exists" => "Assignment does not exist",
            "mark.required" => "Mark is required",
            "mark.numeric" => "Mark must be a number",
            "remarks.required" => "Remarks are required",
            "date_assigned.required" => "Date assigned is required",
            "date_assigned.date" => "Date assigned must be a valid date"
        ];
    }
}
