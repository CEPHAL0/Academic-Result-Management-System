<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

use App\Http\Requests\DepartmentRequest;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        try {

            $departments = Department::all()->sortBy("name");
            return view("admin.departments.index", compact("departments"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["error" => "Failed to retrieve departments."]);
        }
    }

    public function create()
    {


        try {
            $users = User::whereHas('roles', function ($query) {
                return $query->where("name", "HOD");
            })->get()->sortBy("name");

            return view("admin.departments.create", compact("users"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["error" => "Failed to create department."]);
        }
    }

    public function store(DepartmentRequest $request)
    {
        try {
            $data = $request->validated();

            $hodRoleId = Role::where("name", "hod")->firstOrFail()->id;
            $hasHodRole = DB::table("role_users")->where("role_id", $hodRoleId)->where("user_id", $data["head_of_department_id"])->exists();

            if (!$hasHodRole) {
                return redirect()->back()->withInput()->withErrors(["error" => "User does not have HOD role."]);
            }

            Department::create($data);

            return redirect(route("departments.index"))->with("success", "Department Updated Successfully.");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["error" => "Failed to update Department."]);
        }
    }

    public function edit($id)
    {
        try {
            $department = Department::findOrFail($id);
            
            $users = User::whereHas('roles', function ($query) {
                return $query->where("name", "HOD");
            })->get()->sortBy("name");
            return view("admin.departments.edit", compact("department", "users"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["error" => "Failed to edit Department."]);
        }
    }

    public function update(DepartmentRequest $request, $id)
    {
        try {
            $input = $request->validated();
            $department = Department::findOrFail($id);


            $hodRoleId = Role::where("name", "hod")->firstOrFail()->id;
            $hasHodRole = DB::table("role_users")->where("role_id", $hodRoleId)->where("user_id", $input["head_of_department_id"])->exists();

            if (!$hasHodRole) {
                return redirect()->back()->withInput()->withErrors(["error" => "User doesnot have HoD role"]);
            }

            $department->update($input);

            return redirect(route("departments.index"))->with("success", "Department Updated Successfully.");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["error" => "Failed to update Department."]);
        }
    }

    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);


            $department->delete();

            // Add subject check here and throw error if department has subjects 

            return redirect(route("departments.index"))->with("success", "Department Deleted Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["error" => "Failed to delete Department."]);
        }
    }
}
