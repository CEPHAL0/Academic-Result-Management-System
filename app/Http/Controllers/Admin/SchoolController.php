<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Http\Requests\SchoolRequest;
use App\Models\School;
use App\Models\Grade;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SchoolController extends Controller
{
    //
    public function index()
    {
        try {
            $schools = School::all()->sortBy("name");
            return view("admin.schools.index", compact("schools"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to retrieve schools."]);
        }
    }

    public function create()
    {
        try {
            $grades = Grade::all()->sortBY("name");

            $users = User::whereHas('roles', function ($query) {
                return $query->where("name", "HOS");
            })->get()->sortBy("name");

            return view("admin.schools.create", compact("grades", "users"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to retrieve School."]);
        }
    }

    public function store(SchoolRequest $request)
    {
        $data = $request->validated();
        try {
            $hosRoleId = Role::where("name", "hos")->firstOrFail()->id;
            $hasHosRole = DB::table("role_users")->where("user_id", $data['head_of_school_id'])->where("role_id", $hosRoleId)->exists();

            if (!$hasHosRole) {
                throw new Exception("Teacher not assigned HOS Role");
            }

            $teacherId = $data['head_of_school_id'];

            $schoolWithHeadOfSchoolExists = School::whereHas("headOfSchool", function ($query) use ($teacherId) {
                return $query->where("id", $teacherId);
            })->exists();

            if ($schoolWithHeadOfSchoolExists) {
                return redirect()->back()->withInput()->withErrors(["error" => "User already assigned HOS in another school"]);
            }

            School::create($data);

            return redirect(route("schools.index"))->with("success", "School created Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create School."]);
        }
    }

    public function edit($id)
    {
        try {
            $school = School::findOrFail($id);


            $users = User::whereHas('roles', function ($query) {
                return $query->where("name", "HOS");
            })->get()->sortBy("name");

            return view("admin.schools.edit", compact("school", "users"));

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "School not found."]);
        }
    }

    public function update(SchoolRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $school = School::findOrFail($id);

            $hosRoleId = Role::where("name", "hos")->firstOrFail()->id;
            $hasHosRole = DB::table("role_users")->where("user_id", $data['head_of_school_id'])->where("role_id", $hosRoleId)->exists();

            if (!$hasHosRole) {
                return redirect()->back()->withInput()->withErrors(["errors" => "User does not have HOS School."]);
            }

            $teacherId = $data['head_of_school_id'];

            $schoolWithHeadOfSchoolExists = School::whereHas("headOfSchool", function ($query) use ($teacherId) {
                return $query->where("id", $teacherId);
            })->where("id", "!=", $id)->exists();

            if ($schoolWithHeadOfSchoolExists) {
                return redirect()->back()->withInput()->withErrors(["error" => "User already assigned HOS in another school"]);
            }

            $school->update($data);

            return redirect(route("schools.index"))->with("success", "School updated Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to update School."]);
        }
    }

    public function destroy($id)
    {
        try {
            $school = School::findOrFail($id);

            $school->delete();

            return redirect(route("schools.index"))->with("success", "School deleted Successfully");

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to delete school."]);
        }
    }
}
