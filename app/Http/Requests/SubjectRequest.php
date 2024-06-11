<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
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
        $id = $this->route("subject");

        return [
            //
            "name" => ["required"],
            "subject_code" => ["required", Rule::unique("subjects", "subject_code")->ignore($id)],
            "department_id" => ["required", "exists:departments,id"],
            "type" => ["required", "in:MAIN,ECA,CREDIT"],
            "grade_id" => ["required", "exists:grades,id"],
            "credit_hr" => ["required", "numeric", "min:0"]
        ];
    }


    public function prepareForValidation(): void
    {
        $this->merge([
            "name" => ucwords(strtolower($this->input("name"))),
        ]);
    }

    public function messages()
    {
        return [
            "name.required" => "Subject name is required",
            "subject_code.required" => "Subject code is required",
            "subject_code.unique" => "Subject code already exists",
            "department_id.required" => "Department is required",
            "department_id.exists" => "Department does not exist",
            "type.required" => "Subject type is required",
            "type.in" => "Subject type must be MAIN, ECA or CREDIT",
            "grade_id.required" => "Grade is required",
            "grade_id.exists" => "Grade does not exist",
            "credit_hr.required" => "Credit hours are required",
            "credit_hr.numeric" => "Credit hours must be a number",
            "credit_hr.min" => "Credit hours must be greater than or equal to 0"
        ];
    }
}
