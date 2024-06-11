<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        try {
            $teacherId = auth()->id();

            $subjectTeachers = SubjectTeacher::whereHas('subject.department', function ($query) use ($teacherId) {
                $query->where("head_of_department_id", $teacherId);
            })->get()->sortBy("subject.grade.name");

            return view('hod.dashboard.index')->with(compact('subjectTeachers'));

        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Failed to retrieve classes"]);
        }
    }


}
