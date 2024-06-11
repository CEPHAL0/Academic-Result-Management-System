<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectTeacherRequest;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectTeacherController extends Controller
{
    //
    public function index()
    {
        try {
            $teacherId = auth()->id();

            $subjectTeachers = SubjectTeacher::whereHas("subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("section.grade.name");

            return view("hos.subject-teachers.index", compact("subjectTeachers"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve subject teachers"]);
        }
    }

    public function create()
    {
        try {
            $teacherId = auth()->id();

            $subjects = Subject::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");

            $sections = Section::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");

            $teachers = User::all()->sortBy("name");

            return view("hos.subject-teachers.create", compact("subjects", "sections", "teachers"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve subject teachers"]);
        }
    }

    public function store(SubjectTeacherRequest $request)
    {
        $data = $request->validated();
        try {
            $subjectId = $data['subject_id'];
            $teacherId = $data['teacher_id'];
            $sectionId = $data['section_id'];

            $subjectTeacherExists = SubjectTeacher::where("subject_id", $subjectId)->where("teacher_id", $teacherId)->where("section_id", $sectionId)->exists();

            if ($subjectTeacherExists) {
                return redirect()->back()->withInput()->withErrors(["Error", "Failed to save subject teachers: Subject Teacher Already Exists"]);
            }

            SubjectTeacher::create($data);

            return redirect(route("hosSubjectTeachers.index"))->with("success", "Teacher Assigned grade and section successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["Error", "Failed to save subject teachers"]);
        }
    }

    public function edit(int $subjectTeacherId)
    {
        try {
            $teacherId = auth()->id();
            $subjectTeacher = SubjectTeacher::where("id", $subjectTeacherId)->whereHas("subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $subjects = Subject::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");

            $sections = Section::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");

            $teachers = User::all()->sortBy("name");

            return view("hos.subject-teachers.edit", compact("subjectTeacher", "subjects", "sections", "teachers"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Subject Teacher not found"]);
        }
    }

    public function update(int $subjectTeacherId, SubjectTeacherRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $subjectTeacherExists = SubjectTeacher::where("subject_id", $data["subject_id"])->where("section_id", $data["section_id"])->where("teacher_id", $data["teacher_id"])->where("id", "!=", $subjectTeacherId)->exists();

            if ($subjectTeacherExists) {
                return redirect()->back()->withInput()->withErrors(["Error", "Subject Teacher already exists"]);
            }

            $subjectTeacher = SubjectTeacher::where("id", $subjectTeacherId)->whereHas("subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();


            $subjectTeacher->update($data);

            return redirect(route("hosSubjectTeachers.index"))->with("success", "Subject Teacher Updated Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to edit subject teacher"]);
        }

    }

    public function destroy(int $subjectTeacherId)
    {
        try {
            $teacherId = auth()->id();

            $subjectTeacher = SubjectTeacher::where("id", $subjectTeacherId)->whereHas("subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $subjectTeacher->delete();

            return redirect(route("hosSubjectTeachers.index"))->with("success", "Subject Teacher Deleted Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to delete subject teacher"]);
        }
    }
}
