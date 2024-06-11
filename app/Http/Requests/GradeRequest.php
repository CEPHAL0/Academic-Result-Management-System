<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeRequest extends FormRequest
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
        $id = $this->route('grade');
        return [
            "name" => [
                "required",
                "integer",
                Rule::unique("grades", "name")->ignore($id),
                "min:0",
                "max:12"
            ],

            "end_date" => ["date"],

            "school_id" => ["required", "numeric", "exists:schools,id"],
        ];
    }

    public function messages(){
        return [
            "name.required" => "Grade name is required",
            "name.integer" => "Grade name must be a number",
            "name.unique" => "Grade name already exists",
            "name.min" => "Grade name must be greater than or equal to 0",
            "name.max" => "Grade name must be less than or equal to 12",
            "school_id.required" => "School is required",
            "school_id.numeric" => "School must be a number",
            "school_id.exists" => "School does not exist"
        ];
    }
}
