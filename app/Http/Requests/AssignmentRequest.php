<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS;

class AssignmentRequest extends FormRequest
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
            "name" => ["required"],
            "date_assigned" => ["required", "date"],
            "subject_teacher_id" => ["required", "exists:subject_teachers,id"],
            // "description" => ["max:500"],
            "cas_type_id" => ["required", "exists:cas_types,id"],
            // "term_id" => ["required", "exists:terms,id"]
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Assignment name is required",
            "date_assigned.required" => "Assignment date is required",
            "date_assigned.date" => "Assignment date must be a valid date",
            "subject_teacher_id.exists" => "Subject teacher does not exist",
            "cas_type_id.required" => "CAS type is required",
            "cas_type_id.exists" => "CAS type does not exist",
        ];
    }
}
