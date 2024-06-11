<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentEditRequest;
use App\Http\Requests\AssignmentRequest;
use App\Models\Cas;
use App\Models\School;
use App\Models\Subject;
use App\Models\SubjectTeacher;

use App\Http\Requests\TeacherCasStoreRequest;

use Illuminate\Http\Request;
use App\Models\Assignment;

use App\Models\CasType;
use App\Models\Section;
use App\Models\Student;

use App\Models\Term;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teacherId = auth()->id();

            $assignments = Assignment::whereHas("subjectTeacher.subject.department", function ($query) use ($teacherId) {
                $query->where("head_of_department_id", $teacherId);
            })->with(['subjectTeacher', 'casType'])->get()->sortBy("date");

            return view("hod.assignment.index", compact("assignments"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve assignments"]);
        }
    }

    public function view(int $assignmentId)
    {
        try {

            $hodId = auth()->id();

            $assignment = Assignment::where("id", $assignmentId)->whereHas("subjectTeacher.subject.department", function ($query) use ($hodId) {
                return $query->where('head_of_department_id', $hodId);
            })->firstOrFail();

            $cas = Cas::with('student')->where("assignment_id", $assignment->id)->get()->sortBy("student.roll_no");

            return view("hod.assignment.view", compact("assignment", "cas"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Assignment not found"]);
        }
    }

    public function edit(int $id)
    {
        try {
            $hodId = auth()->id();

            // Verify if the user is authenticated to edit this assignment
            $assignment = Assignment::where('id', $id)->whereHas("subjectTeacher.subject.department", function ($query) use ($hodId) {
                return $query->where('head_of_department_id', $hodId);
            })->firstOrFail();


            if ($assignment->submitted == '1') {
                throw new Exception("Cannot edit assignment that is submitted");
            }

            $subjectTeacher = $assignment->subjectTeacher;

            // Retrieve the castypes from the given grade request
            $casTypes = CasType::whereHas("school.grades.sections.subjectTeachers", function ($query) use ($subjectTeacher) {
                return $query->where("teacher_id", $subjectTeacher->teacher_id);
            })->get();

            $cas = Cas::with('student')->where("assignment_id", $assignment->id)->get()->sortBy("student.roll_no");

            return view("hod.assignment.edit", compact('assignment', 'casTypes', 'cas'));


        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Assignment not found"]);
        }
    }

    public function updateAndSave(int $assignmentId, TeacherCasStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();


        try {
            $hodId = auth()->id();

            $assignment = Assignment::where("id", $assignmentId)->whereHas("subjectTeacher.subject.department", function ($query) use ($hodId) {
                return $query->where('head_of_department_id', $hodId);
            })->firstOrFail();



            $date = $data["date_assigned"];


            $term = Term::whereHas("grade", function ($query) use ($assignment) {
                $query->where("id", $assignment->subjectTeacher->subject->grade_id);
            })->where("start_date", "<=", $date)->where("end_date", ">", $date)->firstOrFail();

            $assignment->update([
                "name" => "Week " . $data['assignment_name'],
                "date_assigned" => $data["date_assigned"],
                "cas_type_id" => $data["cas_type"],
                "term_id" => $term->id,
                "submitted" => '0',
            ]);

            $casType = CasType::findOrFail($data["cas_type"]);


            foreach ($data['students'] as $id => $studentId) {
                $cas = Cas::where("student_id", $studentId)->where("assignment_id", $assignment->id)->firstOrFail();

                $formMark = $data["marks"][$id];

                if ($formMark > $casType->full_marks) {
                    throw new Exception("CAS Marks cannot exceed full marks");
                }

                if ($formMark == null) {
                    $formMark = 0;
                }

                $cas->update([
                    "mark" => $formMark
                ]);
            }

            DB::commit();

            return redirect(route('hodAssignments.index'))->with("success", "Edited CAS Marks Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to edit CAS Marks"]);
        }
    }


    public function updateAndStore(int $assignmentId, TeacherCasStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();


        try {
            $hodId = auth()->id();

            $assignment = Assignment::where("id", $assignmentId)->whereHas("subjectTeacher.subject.department", function ($query) use ($hodId) {
                return $query->where('head_of_department_id', $hodId);
            })->firstOrFail();


            $date = $data["date_assigned"];


            $term = Term::whereHas("grade", function ($query) use ($assignment) {
                $query->where("id", $assignment->subjectTeacher->subject->grade_id);
            })->where("start_date", "<=", $date)->where("end_date", ">", $date)->firstOrFail();

            $assignment->update([
                "name" => "Week " . $data['assignment_name'],
                "date_assigned" => $data["date_assigned"],
                "cas_type_id" => $data["cas_type"],
                "term_id" => $term->id,
                "submitted" => '1',
            ]);

            $casType = CasType::findOrFail($data["cas_type"]);



            foreach ($data['students'] as $id => $studentId) {
                $cas = Cas::where("student_id", $studentId)->where("assignment_id", $assignment->id)->firstOrFail();

                $formMark = $data["marks"][$id];

                if ($formMark > $casType->full_marks) {
                    throw new Exception("CAS Marks cannot exceed full marks");
                }

                if ($formMark == null) {
                    throw new Exception("CAS Marks cannot be null");
                }

                $cas->update([
                    "mark" => $formMark
                ]);
            }

            DB::commit();

            return redirect(route('hodAssignments.index'))->with("success", "Stored CAS Marks Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to edit CAS Marks"]);
        }
    }







    public function destroy(int $assignmentId)
    {
        DB::beginTransaction();
        try {

            $teacherId = auth()->id();

            $assignment = Assignment::where("id", $assignmentId)->whereHas("subjectTeacher.subject.department", function ($query) use ($teacherId) {
                return $query->where("head_of_department_id", $teacherId);
            })->firstOrFail();

            $cas = $assignment->cas;

            foreach ($cas as $casOne) {
                $casOne->delete();
            }

            $assignment->delete();
            DB::commit();


            return redirect(route('hodAssignments.index'))->with("success", "Deleted CAS Marks Successfully");

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors(["Error" => "Failed to delete CAS Marks"]);
        }
    }





}
