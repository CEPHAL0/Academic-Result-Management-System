<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\CasType;
use App\Models\SubjectTeacher;
use App\Models\Term;
use App\Models\Grade;
use App\Models\Section;
use Exception;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher_id = auth()->id();

        $assignments = Assignment::whereHas("subjectTeacher", function ($query) use ($teacher_id) {
            $query->where("teacher_id", $teacher_id);
        })->get();

        return view("admin.assignments.index", compact("assignments"));
    }

    public function create()
    {
        try {
            $teacher_id = auth()->id();

            $cas_types = CasType::whereHas("school.grades.sections.subjectTeachers", function ($query) use ($teacher_id) {
                $query->where("teacher_id", $teacher_id);
            })->get();

            $subject_teachers = SubjectTeacher::where("teacher_id", auth()->id())->get();

            $terms = Term::whereHas("grade.sections.subjectTeachers", function ($query) use ($teacher_id) {
                $query->where("teacher_id", $teacher_id);
            })->get();

            return view("admin.assignments.create", compact("cas_types", "subject_teachers", "terms"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Errors", "Failed to create assignment: "]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentRequest $request)
    {
        $data = $request->validated();
        try {
            Assignment::create($data);

            return redirect(route("assignments.index"))->with("success", "Successfully Created the assignment");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create assignment: "]);
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

        try {
            $assignment = Assignment::findOrFail($id);

            $teacher_id = auth()->id();

            $cas_types = CasType::whereHas("school.grades.sections.subjectTeachers", function ($query) use ($teacher_id) {
                $query->where("teacher_id", $teacher_id);
            })->get();

            $subject_teachers = SubjectTeacher::where("teacher_id", auth()->id())->get();

            $terms = Term::whereHas("grade.sections.subjectTeachers", function ($query) use ($teacher_id) {
                $query->where("teacher_id", $teacher_id);
            })->get();

            return view("admin.assignments.edit", compact("assignment", "cas_types", "subject_teachers", "terms"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors", "Failed to edit the assignment."]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssignmentRequest $request, string $id)
    {
        try {
            $assignment = Assignment::findOrFail($id);

            $data = $request->validated();

            $assignment->update($data);

            return redirect(route("assignments.index"))->with("success", "Assignment Edited Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors", "Error while updating the assignment."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $assignment = Assignment::findOrFail($id);

            $assignment->delete();

            return redirect(route("assignments.index"))->with("success", "Assignment Deleted Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors", "Error while deleting the assignment."]);
        }
    }
}