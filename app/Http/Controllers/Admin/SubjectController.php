<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Models\Department;
use App\Models\Grade;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{

    public function index()
    {
        try {
            $subjects = Subject::all()->sortBy("grade.id");
            return view("admin.subjects.index", compact("subjects"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to retrieve subjects"]);
        }
    }

    public function create()
    {
        try {
            $departments = Department::all()->sortBy("name");

            $grades = Grade::all()->sortBy("name");

            $types = ["MAIN", "CREDIT", "ECA"];

            return view("admin.subjects.create", ["departments" => $departments, "types" => $types, "grades" => $grades]);

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create Subject: "]);
        }
    }


    public function store(SubjectRequest $request)
    {
        $data = $request->validated();
        try {
            Subject::create($data);

            return redirect(route("subjects.index"))->with("success", "Subject Created Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create subject"]);
        }
    }


    public function edit($id)
    {
        try {
            $subject = Subject::findOrFail($id);

            $types = ["MAIN", "CREDIT", "ECA"];

            $grades = Grade::all()->sortBy("name");
            $departments = Department::all()->sortBy("name");

            return view("admin.subjects.edit", compact("subject", "types", "grades", "departments"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to edit Subject"]);
        }
    }

    public function update(SubjectRequest $request, $id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $input = $request->validated();

            $subject->update($input);

            return redirect(route('subjects.index'))->with('success', 'Subject updated successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to update Subject. "]);
        }
    }


    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return redirect(route("subjects.index"))->with("success", "Subject Deleted Successfully");
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to delete subject. "]);
        }
    }
}
