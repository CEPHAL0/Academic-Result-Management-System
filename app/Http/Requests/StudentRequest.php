<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $id = $this->route("student");
        return [
            //
            "image" => ["mimes:png,jpg,jpeg", "max:2000", "file"],
            "name" => ["required"],
            "roll_number" => ["required", "numeric", Rule::unique("students", "roll_number")->ignore($id)],
            "section_id" => ["required", "exists:sections,id"],
            "date_of_birth" => ["required", "date"],
            "father_name" => ["required"],
            "father_contact" => ["required"],
            "mother_name" => ["required"],
            "mother_contact" => ["required"],
            "guardian_name" => ["required"],
            "guardian_contact" => ["required"],
            "email" => ["required", "email"],
            "emis_no" => ["required", "string", Rule::unique("students", "emis_no")->ignore($id)],
            "reg_no" => ["string", Rule::unique("students", "reg_no")->ignore($id), "nullable"],
            "fathers_profession" => ["string"],
            "mothers_profession" => ["string"],
            "guardians_profession" => ["string"],

            "status" => ["in:ACTIVE,DROPPED_OUT"]
        ];
    }


    /*
     * Transform input data before validation
     *
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            "name" => ucwords(strtolower($this->input("name"))),
            "father_name" => ucwords(strtolower($this->input("father_name"))),
            "mother_name" => ucwords(strtolower($this->input("mother_name"))),
            "guardian_name" => ucwords(strtolower($this->input("guardian_name"))),
        ]);
    }

    public function messages()
    {
        return [
            "image.mimes" => "Image must be of type png, jpg, jpeg",
            "image.max" => "Image must be less than 2MB",
            "image.file" => "Image must be a file",
            "name.required" => "Student name is required",
            "roll_number.required" => "Roll number is required",
            "roll_number.numeric" => "Roll number must be a number",
            "roll_number.unique" => "Roll number already exists",
            "section_id.required" => "Section is required",
            "section_id.exists" => "Section does not exist",
            "date_of_birth.required" => "Date of birth is required",
            "date_of_birth.date" => "Date of birth must be a valid date",
            "father_name.required" => "Father name is required",
            "mother_name.required" => "Mother name is required",
            "guardian_name.required" => "Guardian name is required",
            "father_contact.required" => "Father contact is required",
            "mother_contact.required" => "Mother contact is required",
            "guardian_contact.required" => "Guardian contact is required",
            "email.required" => "Email is required",
            "email.email" => "Email must be a valid email",
            "emis_no.required" => "EMIS number is required",
            "emis_no.string" => "EMIS number must be a string",
            "emis_no.unique" => "EMIS number already exists",
            "reg_no.string" => "Registration number must be a string",
            "reg_no.unique" => "Registration number already exists",
            "fathers_profession.string" => "Father's profession must be a string",
            "mothers_profession.string" => "Mother's profession must be a string",
            "guardians_profession.string" => "Guardian's profession must be a string",
            "status.in" => "Invalid status"
        ];
    }
}
