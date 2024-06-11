<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamUpdateRequest;
use App\Models\Exam;
use App\Http\Requests\ExamStoreRequest;

use App\Models\StudentExam;
use App\Models\Term;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubjectTeacher;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher_id = auth()->id();
        $exams = Exam::whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id) {
            $query->where("id", $teacher_id);
        })->get()->load("studentExam")->sortBy("studentExam.symbol_no");
        return view("admin.exams.index", compact("exams"));
    }


    public function create(int $subjectTeacher)
    {
        try {
            $teacher_id = auth()->id();
            $subjectTeacher = SubjectTeacher::where("id", $subjectTeacher)->where("teacher_id", $teacher_id)->firstOrFail();
            $students = $subjectTeacher->section->students;
            return view("admin.exams.create", compact("subjectTeacher", "students"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Subject teacher not assigned to the user"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $subjectTeacher, ExamStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $subjectTeacher = SubjectTeacher::findOrFail($subjectTeacher);

            $term = Term::whereHas("grade.sections.subjectTeachers", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->id);
            })->where("start_date", "<=", $data["date"])->where("end_date", ">", $data["date"])->firstOrFail();

            foreach ($data["student_ids"] as $key => $studentId) {
                $studentExam = StudentExam::create([
                    "student_id" => $studentId,
                    "symbol_no" => $data["symbol_nos"][$key]
                ]);

                Exam::create([
                    "student_exam_id" => $studentExam->id,
                    "term_id" => $term->id,
                    "type" => $data["type"],
                    "subject_teacher_id" => $subjectTeacher->id,
                    "mark" => $data["marks"][$key],
                    "date" => $data["date"]
                ]);
            }
            DB::commit();

            return redirect(route("exam.index"))->with("success", "Exam stored successfully");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to Add Marks in Exam"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $teacher_id = auth()->id();

        $exam = Exam::where("id", $id)->whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id) {
            $query->where("id", $teacher_id);
        })->firstOrFail();

        $subjectTeacher = $exam->subjectTeacher;

        return view("admin.exams.edit", compact("exam"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamUpdateRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $teacher_id = auth()->id();

            $exam = Exam::where("id", $id)->whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id) {
                $query->where("id", $teacher_id);
            })->firstOrFail();

            $subjectTeacher = $exam->subjectTeacher;

            $term = Term::whereHas("grade.sections.subjectTeachers", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->id);
            })->where("start_date", "<=", $data["date"])->where("end_date", ">", $data["date"])->firstOrFail();

            $studentExam = StudentExam::findOrFail($exam->student_exam_id);

            $studentExam->update([
                "student_id" => $exam->studentExam->student->id,
                "symbol_no" => $data['symbol_no']
            ]);

            $exam->update([
                "student_exam_id" => $studentExam->id,
                "term_id" => $term->id,
                "subject_teacher_id" => $subjectTeacher->id,
                "mark" => $data['mark'],
                "date" => $data["date"],
                "type" => $data["type"],
            ]);

            return redirect(route("exam.index"))->with("success", "Successfully Edited the Exam Marks");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Failed to Edit the marks"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $teacher_id = auth()->id();
            $exam = Exam::where("id", $id)->whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id) {
                $query->where("id", $teacher_id);
            })->firstOrFail();

            $studentExam = StudentExam::findOrFail($exam->student_exam_id);

            $exam->delete();
            $studentExam->delete();
            return redirect(route("exam.index"))->with("success", "Successfully Deleted the exam");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Failed to delete the exam: " . $e->getMessage()]);
        }
    }
}
