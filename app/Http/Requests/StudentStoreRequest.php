<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'roll_number' => 'required|numeric|unique:students',
            'section_id' => 'required',
            'date_of_birth' => 'required|date',
            'father_name' => 'required|string|max:255',
            'father_contact' => 'required|numeric',
            'mother_name' => 'required|string|max:255',
            'mother_contact' => 'required|numeric',
            'guardian_name' => 'required|string|max:255',
            'guardian_contact' => 'required|numeric',
            'email' => 'required|email|max:255|unique:students'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Student name is required',
            'roll_number.required' => 'Roll number is required',
            'roll_number.numeric' => 'Roll number must be a number',
            'roll_number.unique' => 'Roll number already exists',
            'section_id.required' => 'Section is required',
            'date_of_birth.required' => 'Date of birth is required',
            'date_of_birth.date' => 'Date of birth must be a valid date',
            'father_name.required' => 'Father name is required',
            'father_contact.required' => 'Father contact is required',
            'mother_name.required' => 'Mother name is required',
            'mother_contact.required' => 'Mother contact is required',
            'guardian_name.required' => 'Guardian name is required',
            'guardian_contact.required' => 'Guardian contact is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email',
            'email.unique' => 'Email already exists'
        ];
    }
}
