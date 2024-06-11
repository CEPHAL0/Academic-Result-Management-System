<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
        $id = $this->route('department');
        return [
            //
            "name" => ["required", Rule::unique('departments', 'name')->ignore($id)],
            "head_of_department_id" => ["required", "exists:users,id"]
        ];
    }

    /*
     * Transform input data before validation    
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            "name" => ucwords(strtolower($this->input("name"))),
        ]);
    }

    public function messages()
    {
        return [
            "name.required" => "Department name is required",
            "name.unique" => "Department name already exists",
            "head_of_department_id.required" => "Head of department is required",
            "head_of_department_id.exists" => "Head of department does not exist"
        ];
    }
}
