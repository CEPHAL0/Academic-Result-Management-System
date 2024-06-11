<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HosExamEditRequest extends FormRequest
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
            "exams" => ["required", "array", "exists:exams,id"],
            "examMarks" => ["required", "array", "min:0", "max:100"],
        ];
    }

    public function messages()
    {
        return [
            "exams.required" => "Exams are required",
            "exams.exists" => "One or more exams do not exist",
            "examMarks.required" => "Exam marks are required",
            "examMarks.min" => "Exam marks must have at least 1 element",
            "examMarks.max" => "Exam marks must have at most 100 elements",
        ];
    }
}
