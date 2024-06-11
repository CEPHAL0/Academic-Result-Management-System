<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Cas;
use App\Models\Exam;
use App\Models\OldAssignment;
use App\Models\OldCasMark;
use App\Models\OldTable;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentExam;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Models\School;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function index()
    {
        try {

            $grades = Grade::get()->sortBy("name");

            return view("admin.grades.index", compact("grades"));

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to retrieve grades.']);
        }
    }

    public function create()
    {
        try {
            $schools = School::all()->sortBy("name");
            return view("admin.grades.create", compact("schools"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to create grade. ']);
        }
    }

    public function store(GradeRequest $request)
    {
        $name = $request->validated();
        try {

            Grade::create($name);

            return redirect(route('grades.index'))->with('success', 'Grade Created Successfully');

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create grade. ']);
        }
    }

    public function edit($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            $schools = School::all()->sortBy("name");

            return view('admin.grades.edit', compact("grade", "schools"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Grade not found"]);
        }
    }

    public function update(GradeRequest $request, int $id)
    {
        try {
            $grade = Grade::findOrFail($id);

            $data = $request->validated();
            $grade->update($data);

            return redirect(route('grades.index'))->with('success', 'Grade Edited Successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create grade. ']);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $grade = Grade::findOrFail($id);
            $exams = Exam::whereHas('term.grade', function ($query) use ($grade) {
                return $query->where('grade_id', $grade->id);
            })->get();
            foreach ($exams as $exam) {
                OldTable::create([
                    'roll_no' => $exam->studentExam->symbol_no,
                    'emis_no' => $exam->studentExam->student->emis_no,
                    'student_name' => $exam->studentExam->student->name,
                    'subject_name' => $exam->subjectTeacher->subject->name,
                    'grade_name' => $grade->name,
                    'term_name' => $exam->term->name,
                    'term_marks' => $exam->mark,
                ]);




            }
            if ($exams->count() > 0) {
                foreach ($exams as $exam) {
                    $exam->delete();
                }
                ;
            }
            $studentExams = StudentExam::whereHas('student.section.grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($studentExams->count() > 0) {
                foreach ($studentExams as $studentExam) {
                    $studentExam->delete();
                }
            }
            $casses = Cas::whereHas('student.section.grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($casses->count() > 0) {

                foreach ($casses as $cas) {
                    OldCasMark::create([
                        'cas_type' => $cas->assignment->casType->name,
                        'cas_marks' => $cas->mark,
                        'assignment_name' => $cas->assignment->name,
                        'subject_name' => $cas->assignment->subjectTeacher->subject->name,
                        'roll_number' => $cas->student->roll_number,
                        'student_name' => $cas->student->name,
                        'term_name' => $cas->assignment->term->name,
                        'grade_name' => $cas->assignment->subjectTeacher->subject->grade->name,
                    ]);
                    $cas->delete();
                }
            }
            $assignments = Assignment::whereHas('term.grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($assignments->count() > 0) {

                foreach ($assignments as $assignment) {
                    OldAssignment::create([
                        'assignment_name' => $assignment->name,
                        'assignment_fullmarks' => $assignment->casType->full_marks,
                    ]);
                    $assignment->delete();
                }
            }
            $studentTeachers = SubjectTeacher::whereHas('subject.grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($studentTeachers->count() > 0) {
                foreach ($studentTeachers as $studentTeacher) {
                    $studentTeacher->delete();
                }
            }
            $students = Student::whereHas('section.grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($students->count() > 0) {
                foreach ($students as $student) {
                    $student->update(['section_id' => null]);
                }
            }
            $sections = Section::whereHas('grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($sections->count() > 0) {
                foreach ($sections as $section) {
                    $section->delete();
                }
            }
            $terms = Term::whereHas('grade', function ($query) use ($grade) {
                return $query->where('id', $grade->id);
            })->get();
            if ($terms->count() > 0) {
                foreach ($terms as $term) {
                    $term->delete();
                }
            }
            DB::commit();
            return redirect(route("grades.index"))->with("success", "Data associated to grade deleted successfully!");
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to delete grade data',]);
        }



    }

}
