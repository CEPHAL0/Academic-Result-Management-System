<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

use App\Models\Grade;

class SchoolRequest extends FormRequest
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
        $id = $this->route('school');
        return [
            //
            "name" => ["required", Rule::unique("schools", "name")->ignore($id)],
            "head_of_school_id" => ["required", "exists:users,id"],
            "theory_weightage" => ["numeric", "max:100", "min:0"],
            "cas_weightage" => ["numeric", "max:100", "min:0"]
        ];
    }

    public function messages(){
        return [
            "name.required" => "School Name is required.",
            "name.unique" => "School Name already exists.",
            "head_of_school_id.required" => "Head of School is required.",
            "head_of_school_id.exists" => "Head of School does not exist.",
            "theory_weightage.numeric" => "Theory Weightage must be a number.",
            "theory_weightage.max" => "Theory Weightage must be less than or equal to 100.",
            "theory_weightage.min" => "Theory Weightage must be greater than or equal to 0.",
            "cas_weightage.numeric" => "CAS Weightage must be a number.",
            "cas_weightage.max" => "CAS Weightage must be less than or equal to 100.",
            "cas_weightage.min" => "CAS Weightage must be greater than or equal to 0."
        ];
    }

    // protected function withValidator(Validator $validator): void
    // {
    //     $validator->after(function ($validator) {
    //         $startClassId = $this->input("start_class_id");
    //         $endClassId = $this->input("end_class_id");

    //         $startClassName = Grade::findOrFail($startClassId)->name;
    //         $endClassName = Grade::findOrFail($endClassId)->name;

    //         if ($startClassName >= $endClassName) {
    //             $validator->errors()->add(
    //                 'end_class_id',
    //                 'End Class must be greater than Start Class.'
    //             );
    //         }
    //     });
    // }
}
