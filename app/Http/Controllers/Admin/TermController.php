<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TermRequest;
use App\Models\Term;
use App\Models\Grade;

use Exception;
use Illuminate\Support\Facades\Log;

class TermController extends Controller
{
    public function index()
    {
        try {
            $terms = Term::all()->sortBy("grade.name");
            return view("admin.terms.index", compact("terms"));
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["Error", "Cannot retrieve terms"]);
        }
    }

    public function create()
    {
        try {

            $grades = Grade::all()->sortBy("name");
            return view("admin.terms.create", compact("grades"));

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to retrieve terms']);
        }
    }

    public function store(TermRequest $request)
    {
        try {
            $data = $request->validated();

            foreach ($data["grade_id"] as $grade_id) {
                $termData = [
                    "name" => $data["name"],
                    "start_date" => $data["start_date"],
                    "end_date" => $data["end_date"],
                    "grade_id" => $grade_id,
                    "result_date"=>$data["result_date"],
                ];
                Term::create($termData);
            }

            return redirect(route('terms.index'))->with('success', 'Term Created Successfully');

        } catch (Exception $e) {
            Log::error($e->getMessage());   
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create Term']);
        }

    }

    public function edit($id)
    {
        try {
            $term = Term::findOrFail($id);

            $grades = Grade::all()->sortBy("name");

            return view('admin.terms.edit', compact("grades", "term"));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Term not found']);
        }
    }

    public function update(TermRequest $request, $id)
    {
        $data = $request->validated();
        
        try {
            $term = Term::findOrFail($id);

            $term->update($data);

            return redirect(route("terms.index"))->with("success", "Term Updated Successfully");

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update term.']);
        }
    }

    public function destroy($id)
    {
        try {
            $term = Term::findOrFail($id);
            $term->delete();
            return redirect(route("terms.index"))->with("success", "Term Deleted Successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to delete term. "]);
        }
    }
    public function downloadResult(Term $terms)
    {
        try {

            $term = Term::findOrFail($terms->id);
            $filePath = storage_path("app/Grade " . $term->grade->name . ".zip");


            if (file_exists($filePath)) {

                return response()->download($filePath);
            } else {

                return redirect()->back()->withErrors(["errors" => "File not found."]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["errors" => "Failed to download file."]);
        }
    }
}