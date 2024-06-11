<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use App\Models\School;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    //
    public function index()
    {
        $teacherId = auth()->id();

        $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->get()->sortBy("name");

        return view("hos.grades.index", compact("grades"));
    }

    public function create()
    {
        try {
            $teacherId = auth()->id();
            $school = School::where("head_of_school_id", $teacherId)->firstOrFail();
            return view("hos.grades.create", compact("school"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["Error", "School Not Assigned"]);
        }
    }

    public function store(GradeRequest $request)
    {
        try {
            $data = $request->validated();

            Grade::create($data);

            return redirect(route('hosGrades.index'))->with('success', 'Grade Created Successfully');

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create grade: ']);
        }
    }

    public function edit(int $gradeId)
    {
        $teacherId = auth()->id();
        try {

            $grade = Grade::where("id", $gradeId)->whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $school = School::where("head_of_school_id", $teacherId)->firstOrFail();

            return view('hos.grades.edit', compact("grade", "school"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Grade not found"]);
        }
    }

    public function update(int $gradeId, GradeRequest $request)
    {

        try {
            $grade = Grade::findOrFail($gradeId);

            $data = $request->validated();
            $grade->update($data);

            return redirect(route('hosGrades.index'))->with('success', 'Grade Edited Successfully');

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create grade: ']);
        }
    }

    public function destroy($gradeId)
    {
        try {
            $grade = Grade::findOrFail($gradeId);

            if (count($grade->sections) > 0) {
                return redirect()->back()->withErrors(['error' => 'Grade has sections']);
            }

            $grade->delete();

            return redirect(route("hosGrades.index"))->with("success", "Grade Deleted Successfully");

        } catch (Exception $e) {

            Log::error($e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Failed to delete grade ']);
        }
    }


}
