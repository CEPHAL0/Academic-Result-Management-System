<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
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
        $id = $this->route("section");
        return [
            //
            "name" => ["required", Rule::unique("sections")->ignore($id)],
            "grade_id" => ["required", "exists:grades,id"],
            "class_teacher_id" => ["required", "exists:users,id"],
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
            "name.required" => "Section name is required",
            "name.unique" => "Section name already exists",
            "grade_id.required" => "Grade is required",
            "grade_id.exists" => "Grade does not exist",
            "class_teacher_id.required" => "Class teacher is required",
            "class_teacher_id.exists" => "Class teacher does not exist"
        ];
    }
}
