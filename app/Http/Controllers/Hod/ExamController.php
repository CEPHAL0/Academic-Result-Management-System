<?php

namespace App\Http\Controllers\Hod;

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
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teacherId = auth()->id();

            $subjects = Subject::whereHas('department', function ($query) use ($teacherId) {
                return $query->where("head_of_department_id", $teacherId);
            })->get()->sortBy("grade.name");

            $terms = Term::whereHas("grade.sections.subjectTeachers.subject", function ($query) use ($subjects) {
                // return $query->where("subject_id", $subjects->pluck('id')->toArray());
            })->get()->sortBy('grade.name');

            return view("hod.exam.index", compact("terms", "subjects"));
        } catch (Exception $e) {

            Log::error($e->getMessage());

            return redirect()->back()->withErrors(["errors" => "Failed to retrieve exams"]);
        }

    }

    public function view(int $termId, int $subjectId)
    {
        try {
            $teacherId = auth()->id();

            $subjects = Subject::whereHas('department', function ($query) use ($teacherId) {
                return $query->where("head_of_department_id", $teacherId);
            })->get();

            $term = Term::with('exams')->where("id", $termId)->whereHas("grade.sections.subjectTeachers", function ($query) use ($subjects) {
                return $query->where('subject_id', $subjects->pluck('id')->toArray());
            })->firstOrFail();

            $subject = Subject::findOrFail($subjectId);

            $exams = Exam::where("term_id", $term->id)->whereHas("subjectTeacher.subject.department", function ($query) use ($subject) {
                return $query->where("head_of_department_id", $subject->department->head_of_department_id);
            })->get()->sortBy("studentExam.student.roll_number");


            return view('hod.exam.view', compact("term", "exams"));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors(["errors" => "Failed to retrieve exams"]);
        }

    }

}
