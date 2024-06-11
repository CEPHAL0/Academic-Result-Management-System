<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
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

            $subjectTeachers = SubjectTeacher::whereHas("subject.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("subject.grade.name");

            return view("hos.dashboard.index", compact("subjectTeachers"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Failed to retrieve classes"]);
        }
    }
}
