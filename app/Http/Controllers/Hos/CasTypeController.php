<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\CasTypeRequest;
use App\Models\CasType;
use App\Models\School;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CasTypeController extends Controller
{
    //

    public function index()
    {
        try {
            $teacherId = auth()->id();

            $casTypes = CasType::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("school.name");

            return view("hos.cas-types.index", compact("casTypes"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot retrieve CAS Types"]);
        }
    }

    public function create()
    {
        $teacherId = auth()->id();
        try {
            $school = School::where("head_of_school_id", $teacherId)->firstOrFail();
            return view("hos.cas-types.create", compact("school"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "School with the HOS not found"]);
        }
    }

    public function store(CasTypeRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();
            $schoolId = $data["school_id"];

            $school = School::where("id", $schoolId)->where("head_of_school_id", $teacherId)->firstOrFail();

            $schoolCasWeightage = $school->casTypes->sum("weightage") + $data["weightage"];

            if ($schoolCasWeightage > 100) {
                return redirect()->back()->withInput()->withErrors(["Error", "CASType weigthage sum cannot exceed 100 for the school. "]);
            }

            CasType::create([
                "name" => $data["name"],
                "school_id" => $data["school_id"],
                "full_marks" => $data["weightage"],
                "weightage" => $data["weightage"]
            ]);

            return redirect(route("hosCasTypes.index"))->with("success", "Successfully created CAS Type");

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(["Error", "Cannot create castype. "]);
        }


    }

    public function edit(int $casTypeId)
    {
        $teacherId = auth()->id();
        try {
            $casType = CasType::where("id", $casTypeId)->whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $school = School::where("head_of_school_id", $teacherId)->firstOrFail();

            return view("hos.cas-types.edit", compact("school", "casType"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "School with the HOS not found"]);
        }
    }

    public function update(int $casTypeId, CasTypeRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $schoolId = $data["school_id"];

            $casType = CasType::findOrFail($casTypeId);

            $school = School::where("id", $schoolId)->where("head_of_school_id", $teacherId)->firstOrFail();


            $schoolCasWeightage = $school->casTypes->sum("weightage") + $data["weightage"] - $casType->weightage;


            if ($schoolCasWeightage > 100) {
                return redirect()->back()->withInput()->withErrors(["errors" => "CASType weightage sum canot exceed 100 for the school. "]);
            }

            $casType->update([
                "name" => $data["name"],
                "school_id" => $data["school_id"],
                "full_marks" => $data["weightage"],
                "weightage" => $data["weightage"]
            ]);

            return redirect(route("hosCasTypes.index"))->with("success", "Successfully updated the CAS Type");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Error while updating the cas type"]);
        }
    }

    public function destroy(int $casTypeId)
    {

        try {
            $teacherId = auth()->id();

            $casType = CasType::where("id", $casTypeId)->whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $casType->delete();
            return redirect(route("hosCasTypes.index"))->with("success", "Successfully deleted the CAS Type");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot delete CAS Type"]);
        }
    }
}
