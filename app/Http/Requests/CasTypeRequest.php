<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CasTypeRequest extends FormRequest
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
            "name" => ["required"],
            "school_id" => ["required", "exists:schools,id"],
            "weightage" => ["required", "numeric", "min:0", "max:100"]
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "CAS type name is required",
            "school_id.required" => "School is required",
            "school_id.exists" => "School does not exits",
            "weightage.required" => "Weightage is required",
            "weightage.numeric" => "Weightage must be a number",
            "weightage.min" => "Weightage must be greater than or equal to 0",
            "weightage.max" => "Weightage must be less than or equal to 100"

        ];
    }
}
