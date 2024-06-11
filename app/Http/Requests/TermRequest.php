<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TermRequest extends FormRequest
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
        $id = $this->route("term");
        return [
            "name" => ["required"],
            "start_date" => ["required", "date"],
            "end_date" => ["required", "date", "after:start_date"],
            "result_date" => ["required", "date", "after:end_date"],
            "grade_id" => ["required", "exists:grades,id"]
        ];
    }

    /**
     * Transform input data before validation.
     *
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => ucwords(strtolower($this->input('name'))), // Capitalize the first letter of the section name
        ]);
    }

    public function messages(){
        return [
            "name.required" => "Term name is required",
            "start_date.required" => "Start date is required",
            "start_date.date" => "Start date must be a valid date",
            "end_date.required" => "End date is required",
            "end_date.date" => "End date must be a valid date",
            "end_date.after" => "End date must be after the start date",
            "grade_id.required" => "Grade is required",
            "grade_id.exists" => "Grade does not exist"
        ];
    }
}
