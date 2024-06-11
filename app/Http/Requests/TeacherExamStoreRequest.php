<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherExamStoreRequest extends FormRequest
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
            "studentExams" => ["required", "array", "exists:students,id"],
            "examMarks" => ["required", "array", "min:0", "max:100"],
            "term_id" => ["required", "exists:terms,id"],
        ];
    }

    public function messages()
    {
        return [
            "studentExams.required" => "Students are required",
            "studentExams.exists" => "One or more students do not exist",
            "examMarks.required" => "Exam marks are required",
            "examMarks.min" => "Exam marks must have at least 1 element",
            "examMarks.max" => "Exam marks must have at most 100 elements",
            "term_id.required" => "Term is required",
            "term_id.exists" => "Term does not exist",
        ];
    }
}
