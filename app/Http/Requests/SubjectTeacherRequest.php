<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

use App\Models\Grade;
use App\Models\GradeSubject;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\User;


class SubjectTeacherRequest extends FormRequest
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
        $id = $this->route("subject_teacher");
        return [
            "subject_id" => ["required", "exists:subjects,id"],
            "teacher_id" => ["required", "exists:users,id"],
            "section_id" => ["required", "exists:sections,id"],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $id = $this->route("subject_teachers");

        // Check if the section belongs to the grade of the subject
        $validator->after(function ($validator) use ($id) {
            try {
                $sectionId = $this->input('section_id');
                $teacherId = $this->input('teacher_id');
                $subjectId = $this->input('subject_id');

                $section = Section::findOrFail($sectionId);
                $subject = Subject::findOrFail($subjectId);

                if ($section->grade_id != $subject->grade_id) {
                    throw new Exception("Section and Subject not found");
                }
            } catch (Exception $e) {
                $validator->errors()->add('input', 'Invalid Choices');
            }
        });
    }

    public function messages()
    {
        return [
            "subject_id.required" => "Subject is required",
            "subject_id.exists" => "Subject does not exist",
            "teacher_id.required" => "Teacher is required",
            "teacher_id.exists" => "Teacher does not exist",
            "section_id.required" => "Section is required",
            "section_id.exists" => "Section does not exist",
        ];
    }
}
