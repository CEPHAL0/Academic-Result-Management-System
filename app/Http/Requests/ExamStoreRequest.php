<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Grade;
use App\Models\GradeSubject;
use App\Models\Student;
use App\Models\SubjectTeacher;
use App\Models\Term;

use Illuminate\Validation\Rule;

class ExamStoreRequest extends FormRequest
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
        $id = $this->route("exam");

        return [
            //
            "date" => ["required", "date"],
            "type" => ["required", "in:THEORY,PRACTICAL"],
            "symbol_nos" => ["required", "array"],
            "student_ids" => ["required", "array", "exists:students,id"],
            "marks" => ["required", "array", "min:0", "max:100"]


            // Rule::unique('exams')->ignore($id)->where(function ($query) {
            //     $query->where('student_id', $this->input('student_id'))
            //         ->where('subject_teacher_id', $this->input('subject_teacher_id'))
            //         ->where('term_id', $this->input('term_id'))
            //         ->where('name', $this->input('name'));
            // }),
        ];
    }

    public function messages()
    {
        return [
            "date.required" => "Date is required",
            "date.date" => "Date must be a valid date",
            "type.required" => "Type is required",
            "type.in" => "Type must be THEORY or PRACTICAL",
            "symbol_nos.required" => "Symbol numbers are required",
            "student_ids.required" => "Student ids are required",
            "student_ids.exists" => "One or more students do not exist",
            "marks.required" => "Marks are required",
            "marks.min" => "Marks must have at least 1 element",
            "marks.max" => "Marks must have at most 100 elements"
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            "name" => ucwords(strtolower($this->input("name"))),
        ]);
    }

    // public function withValidator(Validator $validator): void
    // {
    //     $validator->after(function ($validator) {
    //         $subject_teacher_id = $this->input("subject_teacher_id");
    //         $student_id = $this->input("student_id");
    //         $term_id = $this->input("term_id");

    //         $subject_teacher = SubjectTeacher::findOrFail($subject_teacher_id);

    //         $student = Student::findOrFail($student_id);

    //         // Check if the section of teacher is same as the section of student
    //         if ($subject_teacher->section->id != $student->section->id) {
    //             $validator->errors()->add("section_id", "Student doesnot belong to the section");
    //         }


    //         // Check if the grade of the term and grade of the student is same
    //         $term = Term::findOrFail($term_id);
    //         if ($term->grade->id != $student->section->grade->id) {
    //             $validator->errors()->add("grade_id", "Term doesnot belong to the grade of the Student");
    //         }
    //     });
    // }
}
