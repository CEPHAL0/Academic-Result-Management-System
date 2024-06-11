<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Section;
use App\Models\Grade;
use App\Http\Requests\SectionRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function index()
    {
        try {
            $sections = Section::with("classTeacher")->get()->sortBy("grade.name");
            
            return view("admin.sections.index", compact("sections"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve sections"]);
        }

    }

    public function create()
    {
        try {
            $grades = Grade::all()->sortBy("name");

            $teachers = User::all()->sortBy("name");

            return view("admin.sections.create", compact("grades", "teachers"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve sections"]);
        }
    }

    public function store(SectionRequest $request)
    {
        $data = $request->validated();
        try {

            $section = Section::create($data);

            return redirect(route("sections.index"))->with("success", "Section Created Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors", "Failed to create Section"]);
        }
    }



    public function edit($id)
    {
        try {
            $section = Section::findOrFail($id);

            $grades = Grade::all()->sortBy('name');

            $classTeachers = User::all()->sortBy("name");

            return view("admin.sections.edit", compact("section", "grades", "classTeachers"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve sections"]);
        }
    }

    public function update(SectionRequest $request, $id)
    {
        try {
            $section = Section::findOrFail($id);
            $data = $request->validated();

            $section->update($data);

            return redirect(route("sections.index"))->with("success", "Section Updated Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["error" => "Failed to update Section"]);
        }
    }

    public function destroy($id)
    {
        try {
            $section = Section::find($id);

            $section->delete();

            return redirect(route("sections.index"))->with("success", "Grade Deleted Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect(route("sections.index"))->withErrors(["error" => "Failed to delete section"]);
        }
    }
}
