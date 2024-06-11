<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExamStoreRequest;
use App\Http\Requests\TeacherExamStoreRequest;
use App\Models\CasType;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\School;
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

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teacherId = auth()->id();

            $subjects = Subject::whereHas("subjectTeachers.teacher", function ($query) use ($teacherId) {
                return $query->where("id", $teacherId);
            })->get()->sortBy("grade.name");


            $terms = Term::whereHas("grade.sections.subjectTeachers", function ($query) use ($teacherId) {
                return $query->where("teacher_id", $teacherId);
            })->get()->sortBy('grade.name');



            return view("teacher.exam.index", compact("terms", "subjects"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["Error", "Cannot retrieve exams"]);
        }

    }

    public function view(int $termId, int $subjectId)
    {
        try {
            $teacherId = auth()->id();

            $term = Term::with('exams')->where("id", $termId)->whereHas("grade.sections.subjectTeachers", function ($query) use ($teacherId) {
                return $query->where('teacher_id', $teacherId);
            })->firstOrFail();

            $exams = Exam::where("term_id", $term->id)->whereHas("subjectTeacher.subject", function ($query) use ($subjectId) {
                return $query->where("id", $subjectId);
            })->whereHas('studentExam.student', function ($query) {
                return $query->where("status", "ACTIVE");
            })->get()->sortBy("studentExam.student.roll_number");

            $subject = Subject::findOrFail($subjectId);


            return view('teacher.exam.view', compact("term", "exams", "subject"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["Error", "Cannot retrieve exams"]);
        }
    }

}
