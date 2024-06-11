<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher_id = auth()->id();

        $subjectTeachers = SubjectTeacher::where("teacher_id", $teacher_id)->get();
        
        return view('teacher.dashboard.index')->with(compact('subjectTeachers'));
    }
}
