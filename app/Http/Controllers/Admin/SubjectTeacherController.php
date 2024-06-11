<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\SubjectTeacherRequest;
use App\Models\Cas;
use App\Models\SubjectTeacher;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Section;
use App\Models\User;
use App\Models\GradeSubject;
use Exception;
use Illuminate\Support\Facades\Log;

class SubjectTeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subject_teachers = SubjectTeacher::all()->sortBy("section.grade.name");

            return view("admin.subject_teachers.index", compact("subject_teachers"));

        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Error while retrieving the classes"]);
        }
    }

    public function showClasses()
    {
        try {
            $teacher = auth()->user();
            $classes = $teacher->subjectTeachers;
            return view("admin.configuration.classes", compact("classes"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Error while retrieving the classes"]);
        }
    }

    public function create()
    {
        try {
            $subjects = Subject::all()->sortBy("grade.name");
            $sections = Section::all()->sortBy("grade.name");
            $teachers = User::all()->sortBy("name");
            return view("admin.subject_teachers.create")->with(compact("subjects", "sections", "teachers"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Error while retrieving the classes"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectTeacherRequest $request)
    {
        $data = $request->validated();
        try {

            $subjectTeacherExists = SubjectTeacher::where("subject_id", $data["subject_id"])->where("section_id", $data["section_id"])->where("teacher_id", $data["teacher_id"])->exists();

            if ($subjectTeacherExists) {
                return redirect()->back()->withInput()->withErrors(["Error", "Failed to save subject teachers: Subject Teacher Already Exists"]);
            }

            SubjectTeacher::create($data);

            return redirect(route("subject-teachers.index"))->with("success", "Teacher assigned grade and Section successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create subject teacher"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect(route("subject-teachers.index"));
    }

    public function edit($id)
    {
        $subjects = Subject::all()->sortBy("grade.name");
        $sections = Section::all()->sortBy("grade.name");
        $teachers = User::all();
        $subject_teacher = SubjectTeacher::findOrFail($id);

        return view("admin.subject_teachers.edit")->with(compact("subjects", "sections", "teachers", "subject_teacher"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectTeacherRequest $request, $id)
    {

        $data = $request->validated();
        // ADD VALIDATION TO PREVENT DUPLICATES WHILE ADDING UPDATED DATA
        try {
            $subject_teacher = SubjectTeacher::findOrFail($id);

            $subjectTeacherExists = SubjectTeacher::where("subject_id", $data["subject_id"])->where("section_id", $data["section_id"])->where("teacher_id", $data["teacher_id"])->where("id", "!=", $subject_teacher->id)->exists();

            if ($subjectTeacherExists) {
                return redirect()->back()->withInput()->withErrors(["Error", "Subject Teacher already exists"]);
            }

            $subject_teacher->update($data);


            return redirect(route("subject-teachers.index"))->with("success", "Updated Teacher Grade and Section successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Cannot update Subject Teacher: "]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subject_teacher = SubjectTeacher::findOrFail($id);
            $subject_teacher->delete();

            return redirect(route("subject-teachers.index"))->with("success", "Successfully Deleted Subject Teacher");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to delete subject teacher"]);
        }
    }
}
