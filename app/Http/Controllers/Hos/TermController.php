<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Models\Grade;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TermController extends Controller
{
    //

    public function index()
    {
        try {
            $teacherId = auth()->id();

            $terms = Term::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("grade.name");

            return view("hos.terms.index", compact("terms"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot retrieve terms"]);
        }

    }

    public function create()
    {
        try {
            $teacherId = auth()->id();

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("name");


            return view("hos.terms.create", compact("grades"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot create terms"]);
        }
    }

    public function store(TermRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $gradeIds = $data["grade_id"];

            foreach ($gradeIds as $gradeId) {

                $gradeBelongsToHeadOfSchool = Grade::where("id", $gradeId)->whereHas("school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->exists();

                if (!$gradeBelongsToHeadOfSchool) {
                    throw new Exception("Grade Doesnot belong to the HOS");
                }

                Term::create([
                    "name" => $data["name"],
                    "start_date" => $data["start_date"],
                    "end_date" => $data["end_date"],
                    "grade_id" => $gradeId,
                    "result_date"=>$data["result_date"],
                ]);
            }

            return redirect(route('hosTerms.index'))->with('success', 'Term Created Successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create Term']);
        }

    }

    public function edit(int $termId)
    {
        try {
            $teacherId = auth()->id();

            $term = Term::where("id", $termId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("name");

            return view("hos.terms.edit", compact("term", "grades"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Term not found']);
        }


    }

    public function update(int $termId, TermRequest $request)
    {
        $data = $request->validated();
        try {
            $teacherId = auth()->id();

            $term = Term::where("id", $termId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $term->update($data);
            return redirect(route('hosTerms.index'))->with('success', 'Term Edited Successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Term not found']);
        }

    }

    public function destroy(int $termId)
    {

        try {
            $teacherId = auth()->id();

            $term = Term::where("id", $termId)->whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->firstOrFail();

            $term->delete();
            return redirect(route('hosTerms.index'))->with('success', 'Term Deleted Successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to delete term']);
        }
    }
}
