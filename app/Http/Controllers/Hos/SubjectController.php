<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use App\Models\Department;
use App\Models\Grade;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    //

    public function index()
    {
        try {
            $teacherId = auth()->id();

            $subjects = Subject::with("grade.school")->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");


            return view("hos.subjects.index", compact("subjects"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot Fetch Subject"]);
        }
    }

    public function create()
    {
        try {
            $teacherId = auth()->id();

            $departments = Department::all()->sortBy("name");

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("name");

            return view('hos.subjects.create', compact("departments", "grades"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["Error", "Cannot Fetch Subject"]);
        }
    }

    public function store(SubjectRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $gradeFromForm = Grade::findOrFail($data["grade_id"]);

            if ($gradeFromForm->school->head_of_school_id != $teacherId) {
                throw new Exception("User is not HOS of the grade");
            }

            $subject = Subject::create($data);

            return redirect(route("hosSubjects.index"))->with("success", "Successfully Created Subject");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["Error", "Failed to Save Subject"]);
        }
    }

    public function edit(int $subjectId)
    {
        try {
            $teacherId = auth()->id();
            $departments = Department::all();

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("name");

            $subject = Subject::where("id", $subjectId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            return view("hos.subjects.edit", compact("departments", "subject", "grades"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['Error', "Subject Not Found"]);
        }
    }

    public function update(int $subjectId, SubjectRequest $request)
    {
        $data = $request->validated();
        try {

            $teacherId = auth()->id();

            $gradeIdFromForm = $data['grade_id'];

            $gradeExists = Grade::where("id", $gradeIdFromForm)->whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->exists();

            if (!$gradeExists) {
                throw new Exception("User is not the HOS of the chosen grade");
            }

            $subject = Subject::findOrFail($subjectId);

            $subject->update($data);

            return redirect(route("hosSubjects.index"))->with('success', "Subject Edited Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['Error', "Failed to edit subject"]);
        }

    }

    public function destroy(int $subjectId)
    {
        try {
            $subject = Subject::findOrFail($subjectId);

            $subject->delete();

            return redirect(route("hosSubjects.index"))->with('success', "Subject Deleted Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['Error', "Failed to edit subject"]);
        }
    }
}
