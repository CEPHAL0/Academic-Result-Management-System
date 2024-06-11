<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCasStoreRequest;
use App\Http\Requests\TeacherExamStoreRequest;
use App\Models\Assignment;
use App\Models\Cas;
use App\Models\CasType;
use App\Models\Exam;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentExam;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HodFormController extends Controller
{
    //

    public function formIndex(int $subjectTeacherId)
    {

        $subjectTeacher = SubjectTeacher::where("id", $subjectTeacherId)->firstOrFail();

        $terms = Term::where("grade_id", $subjectTeacher->section->grade->id)->get();

        $casTypes = CasType::whereHas('school.grades', function ($query) use ($subjectTeacher) {
            return $query->where("id", $subjectTeacher->section->grade->id);
        })->get();

        $examFullMarks = (int) $subjectTeacher->subject->grade->school->theory_weightage;

        $students = $subjectTeacher->section->students->sortBy("roll_number");

        $studentExams = Student::whereHas("section.grade", function ($query) use ($subjectTeacher) {
            return $query->where("id", $subjectTeacher->section->grade->id);
        })->get()->sortBy('roll_number');


        return view('hod.dashboard.form', compact('subjectTeacher', 'terms', "casTypes", "students", "studentExams", "examFullMarks"));
    }


    // Invoked when clicked Save and Submit Exam : Stores Exam marks permanently

    public function storeExam(int $subjectTeacherId, TeacherExamStoreRequest $request)
    {

        $data = $request->validated();


        try {
            $subjectTeacher = SubjectTeacher::findOrFail($subjectTeacherId);

            $term = Term::findOrFail($data["term_id"]);

            $examExists = Exam::where("subject_teacher_id", $subjectTeacher->id)->where("term_id", $term->id)->exists();


            if ($examExists) {
                throw new Exception("Exam already has marks");
            }

            foreach ($data["studentExams"] as $index => $studentId) {

                $studentExam = StudentExam::create([
                    "student_id" => $studentId,
                    "symbol_no" => $studentId + 10,
                ]);

                Exam::create([
                    "student_exam_id" => $studentExam->id,
                    "term_id" => $term->id,
                    "subject_teacher_id" => $subjectTeacher->id,
                    "mark" => $data["examMarks"][$index],
                ]);
            }

            DB::commit();
            return redirect(route('hodExams.index'))->with("success", "Stored Exam Marks Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to store exam marks"]);
        }

    }


    // Invoked when clicked Save and Submit CAS, stores CAS marks and assignment permanently

    public function storeCas(int $subjectTeacherId, TeacherCasStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $date = $data["date_assigned"];

            $subjectTeacher = SubjectTeacher::findOrFail($subjectTeacherId);

            $term = Term::whereHas("grade", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->subject->grade_id);
            })->where("start_date", "<=", $date)->where("end_date", ">", $date)->firstOrFail();

            $assignment = Assignment::create([
                "name" => "Week " . $data['assignment_name'],
                "date_assigned" => $data["date_assigned"],
                "subject_teacher_id" => $subjectTeacher->id,
                "full_marks" => $data["full_marks"],
                "cas_type_id" => $data["cas_type"],
                "term_id" => $term->id,
                "submitted" => '1'
            ]);

            $section = Section::whereHas("subjectTeachers", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->id);
            })->firstOrFail();

            foreach ($data["students"] as $id => $student) {
                $student = Student::where("id", $student)->where("section_id", $section->id)->first();

                if ($data["marks"][$id] > $assignment->full_marks) {
                    throw new Exception("CAS Marks cannot exceed full marks");
                }

                if ($data["marks"][$id] == null) {
                    throw new Exception("CAS Marks cannot be null");
                }

                Cas::create([
                    "student_id" => $student->id,
                    "assignment_id" => $assignment->id,
                    "mark" => $data["marks"][$id],
                    "remarks" => ""
                ]);
            }
            DB::commit();

            return redirect(route('hodAssignments.index'))->with("success", "Stored CAS Marks Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to create CAS Marks"]);
        }

    }

    // Invoked when clicked Save CAS, stores CAS marks temporarily, can accept null marks
    public function saveCas(int $subjectTeacherId, TeacherCasStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();


        try {
            $date = $data["date_assigned"];

            $subjectTeacher = SubjectTeacher::findOrFail($subjectTeacherId);

            $term = Term::whereHas("grade", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->subject->grade_id);
            })->where("start_date", "<=", $date)->where("end_date", ">", $date)->firstOrFail();

            $assignment = Assignment::create([
                "name" => "Week " . $data['assignment_name'],
                "date_assigned" => $data["date_assigned"],
                "subject_teacher_id" => $subjectTeacher->id,
                "cas_type_id" => $data["cas_type"],
                "term_id" => $term->id,
                "submitted" => '0',
            ]);

            $section = Section::whereHas("subjectTeachers", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->id);
            })->firstOrFail();

            $casType = CasType::findOrFail($data['cas_type']);

            foreach ($data["students"] as $id => $student) {
                $student = Student::where("id", $student)->where("section_id", $section->id)->first();

                if ($data["marks"][$id] > $casType->full_marks) {
                    throw new Exception("CAS Marks cannot exceed full marks");
                }


                // Set the marks to 0 to show empty when the marks is not given initially ( helps remove confusion between numbers that are actually zero)
                if ($data["marks"][$id] == null) {
                    $data["marks"][$id] = 0;
                }

                Cas::create([
                    "student_id" => $student->id,
                    "assignment_id" => $assignment->id,
                    "mark" => $data["marks"][$id],
                    "remarks" => ""
                ]);
            }
            DB::commit();

            return redirect(route('hodAssignments.index'))->with("success", "Saved CAS Marks Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to save CAS Marks"]);
        }
    }
}
