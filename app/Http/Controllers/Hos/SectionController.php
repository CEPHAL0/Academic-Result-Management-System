<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Grade;
use App\Models\Section;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    //

    public function index()
    {
        try {
            $teacherId = auth()->id();

            $sections = Section::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->with("grade")->get()->sortBy("grade.name");

            return view("hos.sections.index", compact("sections"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot Retrieve Sections"]);
        }
    }

    public function create()
    {
        try {
            $teacherId = auth()->id();

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("name");

            $teachers = User::all()->sortBy("name");

            return view("hos.sections.create", compact("grades", "teachers"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to Create Section"]);
        }
    }

    public function store(SectionRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $gradeId = $data['grade_id'];

            $gradeBelongsToSchoolOfUser = Grade::where("id", $gradeId)->whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->exists();

            if (!$gradeBelongsToSchoolOfUser) {
                return redirect()->back()->withInput()->withErrors(["Error", "Grade doesnot belong to school"]);
            }

            Section::create($data);

            return redirect(route("hosSections.index"))->with("success", "Successfully created section");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to store the section"]);
        }
    }

    public function edit(int $sectionId)
    {
        try {
            $teacherId = auth()->id();

            $section = Section::where("id", $sectionId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("name");

            $teachers = User::all()->sortBy("name");

            return view("hos.sections.edit", compact("section", "grades", "teachers"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Section not found"]);
        }
    }

    public function update(int $sectionId, SectionRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $gradeId = $data["grade_id"];

            $gradeBelongsToHeadOfSchool = Grade::where("id", $gradeId)->whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->exists();

            if (!$gradeBelongsToHeadOfSchool) {
                return redirect()->back()->withInput()->withErrors(["Error", "Grade doesnot belong to school"]);
            }


            $section = Section::where("id", $sectionId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $section->update($data);

            return redirect(route("hosSections.index"))->with("success", "Successfully updated section");


        } catch (Exception $e) {

            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to update grade"]);
        }
    }

    public function destroy(int $sectionId)
    {
        try {
            $teacherId = auth()->id();

            $section = Section::where("id", $sectionId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $section->delete();

            return redirect(route("hosSections.index"))->with("success", "Successfully deleted section");


        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to delete section"]);
        }
    }

}
