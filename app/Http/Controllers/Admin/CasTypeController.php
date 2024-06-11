<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CasTypeRequest;

use App\Models\CasType;
use App\Models\School;

use Exception;
use Illuminate\Support\Facades\Log;

class CasTypeController extends Controller
{
    /**
     * Display a listing of the re source.
     */
    public function index()
    {
        try {
            $cas_types = CasType::all()->sortBy("school.name");
            return view("admin.cas_types.index")->with(compact("cas_types"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot retrieve CAS Types"]);
        }
    }


    public function create()
    {
        try {
            $schools = School::all()->sortBy("name");

            return view("admin.cas_types.create")->with(compact("schools"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot retrieve CAS Types"]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CasTypeRequest $request)
    {
        $data = $request->validated();

        try {
            $school = School::where("id", $data["school_id"])->firstOrFail();

            $schoolCasWeightage = $school->casTypes->sum("weightage") + $data["weightage"];

            if ($schoolCasWeightage > 100) {
                return redirect()->back()->withInput()->withErrors(["errors" => "CASType weightage sum canot exceed 100 for the school. "]);
            }



            CasType::create([
                "name" => $data["name"],
                "school_id" => $data["school_id"],
                "full_marks" => $data["weightage"],
                "weightage" => $data["weightage"]
            ]);

            return redirect(route("cas-types.index"))->with("success", "Successfully created the CAS Type.");

        } catch (Exception $e) {

            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(["errors" => "Cannot create castype. "]);

        }
    }


    public function edit(int $id)
    {
        try {

            $cas_type = CasType::findOrFail($id);
            $schools = School::all()->sortBy("name");

            return view("admin.cas_types.edit")->with(compact("cas_type", "schools"));

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Cas Type not found: "]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CasTypeRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $cas_type = CasType::findOrFail($id);
            $school = School::where("id", $data["school_id"])->firstOrFail();
            $schoolCasWeightage = $school->casTypes->sum("weightage") + $data["weightage"] - $cas_type->weightage;


            if ($schoolCasWeightage > 100) {
                return redirect()->back()->withInput()->withErrors(["errors" => "CASType weightage sum canot exceed 100 for the school. "]);
            }
            
            $cas_type->update([
                "name" => $data["name"],
                "school_id" => $data["school_id"],
                "full_marks" => $data["weightage"],
                "weightage" => $data["weightage"]
            ]);

            return redirect(route("cas-types.index"))->with("success", "Successfully updated the CAS Type");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Error while updating the CAS Type. "]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $cas_type = CasType::findOrFail($id);
            $cas_type->delete();
            return redirect(route("cas-types.index"))->with("success", "Successfully deleted the CAS Type");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Error while deleting the cas type. "]);
        }
    }
}
