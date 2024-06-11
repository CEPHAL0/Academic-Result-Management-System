<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamUpdateRequest extends FormRequest
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
            "date" => ["date", "required"],
            "symbol_no" => ["required", "numeric"],
            "type" => ["required", "in:THEORY,PRACTICAL"],
            "mark" => ["required", "numeric", "min:0", "max:100"],
        ];
    }
    public function messages(){
        return [
            "date.required" => "Exam date is required",
            "date.date" => "Exam date must be a valid date",
            "symbol_no.required" => "Symbol number is required",
            "symbol_no.numeric" => "Symbol number must be a number",
            "type.required" => "Exam type is required",
            "type.in" => "Exam type must be THEORY or PRACTICAL",
            "mark.required" => "Exam mark is required",
            "mark.numeric" => "Exam mark must be a number",
            "mark.min" => "Exam mark must be greater than or equal to 0",
            "mark.max" => "Exam mark must be less than or equal to 100"
        ];
    }
}
