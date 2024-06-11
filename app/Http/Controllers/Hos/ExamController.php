<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\HosExamEditRequest;
use App\Http\Requests\TeacherExamStoreRequest;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    //

    public function index()
    {
        try {
            $teacherId = auth()->id();

            $subjects = Subject::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");


            $terms = Term::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy('grade.name');

            return view("hos.exams.index", compact("terms", "subjects"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot retrieve exams"]);
        }
    }

    public function edit(int $termId, int $subjectId)
    {
        try {
            $teacherId = auth()->id();

            $term = Term::with('exams')->where("id", $termId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where('head_of_school_id', $teacherId);
            })->firstOrFail();

            $subject = Subject::where("id", $subjectId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where('head_of_school_id', $teacherId);
            })->firstOrFail();

            $terms = Term::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy('grade.name');


            $exams = Exam::where("term_id", $term->id)->whereHas("subjectTeacher.subject", function ($query) use ($subjectId) {
                return $query->where("id", $subjectId);
            })->whereHas('studentExam.student', function ($query){
                return $query->where("status","ACTIVE");
            })->get()->sortBy("studentExam.student.roll_number");

            if ($exams->count() == 0) {
                throw new Exception("No Exam Marks Present");
            }

            $fullMark = (int) $term->grade->school->theory_weightage;


            return view('hos.exams.edit', compact("term", "exams", "subject", "terms", "fullMark"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "No Exam Marks Found"]);
        }
    }


    public function update(int $termId, int $subjectId, HosExamEditRequest $request)
    {
        $data = $request->validated();

        try {
            $teacherId = auth()->id();

            $subjectTeacher = SubjectTeacher::where("subject_id", $subjectId)->whereHas("subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $term = Term::where("id", $termId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $fullMarksOfExam = $subjectTeacher->subject->grade->school->theory_weightage;

            foreach ($data["exams"] as $index => $examId) {

                $exam = Exam::where("id", $examId)->whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->firstOrFail();

                $examMark = $data['examMarks'][$index];

                if ($examMark > $fullMarksOfExam) {
                    throw new Exception("Marks cannot exceed " . $fullMarksOfExam);
                }

                $exam->update(["mark" => $examMark]);
            }

            DB::commit();
            return redirect(route('hosExams.index'))->with("success", "Stored Exam Marks Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to store exam marks"]);
        }
    }


    public function destroy(int $termId, int $subjectId)
    {
        DB::beginTransaction();
        try {
            $teacherId = auth()->id();

            $exams = Exam::where("term_id", $termId)->whereHas("subjectTeacher.subject", function ($query) use ($subjectId) {
                return $query->where("id", $subjectId);
            })->whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get();


            if ($exams->count() == 0) {
                return redirect(route('hosExams.index'))->with("error", "No Exam Marks Found");
            }

            foreach ($exams as $exam) {
                $exam->delete();
            }

            DB::commit();
            return redirect(route('hosExams.index'))->with("success", "Deleted Exam Marks Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to delete exam marks"]);
        }

    }
}
