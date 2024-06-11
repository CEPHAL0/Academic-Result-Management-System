<?php

namespace App\Http\Controllers\Hos;

use App\Helpers\ZipExtractor;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Imports\StudentImport;
use App\Models\Section;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $hosId = auth()->id();

            $students = Student::whereHas("section.grade.school", function ($query) use ($hosId) {
                return $query->where('head_of_school_id', $hosId);
            })->get()->sortBy("roll_number");

            return view('hos.students.index')->with(compact('students'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Cannot retrieve students"]);
        }
    }

    public function create()
    {
        try {
            $hosId = auth()->id();

            $sections = Section::whereHas("grade.school", function ($query) use ($hosId) {
                return $query->where('head_of_school_id', $hosId);
            })->get()->sortBy('grade.name');

            return view('hos.students.create', compact("sections"));

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(["Error", "Page not found"]);
        }
    }
    public function store(StudentRequest $request)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile("image")) {

                $studentName = str_replace(" ", "_", $data['name']);
                $name = $studentName . "_" . $data["roll_number"];

                // Get the file extension
                $extension = $request->file('image')->getClientOriginalExtension();

                // Generate a unique filename to avoid conflicts
                $fileName = $name . '_' . Carbon::now()->timestamp . '.' . $extension;

                // Store the file with the new filename
                $path = $data["image"]->storeAs("students", $fileName, 'public');

                $data["image"] = $fileName;
            }

            $student = Student::create($data);

            return redirect(route('hosStudents.index'))->with('success', 'Student added successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create student"]);
        }
    }

    public function edit($id)
    {
        try {
            $hosId = auth()->id();

            $student = Student::findOrFail($id);

            $sections = Section::whereHas("grade.school", function ($query) use ($hosId) {
                return $query->where('head_of_school_id', $hosId);
            })->get()->sortBy('grade.name');

            return view('hos.students.edit')->with(compact('student', 'sections'));

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to edit student"]);
        }
    }

    public function update(StudentRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $student = Student::findOrFail($id);

            if ($request->hasFile("image")) {

                $studentName = str_replace(" ", "_", $data['name']);
                $name = $studentName . "_" . $data["roll_number"];

                // Get the file extension
                $extension = $request->file('image')->getClientOriginalExtension();

                // Generate a unique filename to avoid conflicts
                $fileName = $name . '_' . Carbon::now()->timestamp . '.' . $extension;

                // Store the file with the new filename
                Storage::delete("public/students/" . $student->image);

                $path = $data["image"]->storeAs("students", $fileName, 'public');

                $data["image"] = $fileName;
            }

            $student->update($data);

            return redirect(route('hosStudents.index'))->with('success', 'Student information updated');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create student"]);
        }
    }

    public function destroy(Student $student)
    {
        try {
            $student = Student::findOrFail($student->id);

            $student->update(["status" => "DROPPED_OUT"]);


            return redirect(route('hosStudents.index'))->with('success', 'Student dropped out successfully');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to delete student"]);
        }
    }

    public function getBulkUpload()
    {
        return view('hos.students.bulkUpload');
    }

    public function bulkSample()
    {
        $file = public_path('file/StudentUploadSample.csv');
        return response()->download($file);
    }

    public function bulkUpload(Request $request)
    {

        $request->validate([
            'student_csv' => 'required|mimes:csv,xlsx,txt',
            'zipFile' => 'required|mimes:zip'
        ]);

        $extension = $request->file('student_csv')->extension();
        $zipFileExtension = $request->file('zipFile')->extension();
        $fileName = time() . '.' . $extension;
        $zipFileName = time() . '.' . $zipFileExtension;
        $path = $request->file('student_csv')->storeAs('public/csv', $fileName);
        $zipFilePath = $request->file('zipFile')->storeAs('public/zip', $zipFileName);
        $extractZipFileToFolder = 'public/students';
        
        try {
            ZipExtractor::extractZip($extractZipFileToFolder, $zipFilePath);
        } catch (Exception $e) {
            return redirect()->route('hosStudents.getBulkUpload')->with('error', $e->getMessage());
        }

        $studentImport = new StudentImport;

        $studentImport->import($path);

        if ($studentImport->failures()->isNotEmpty()) {
            return redirect(route('hosStudents.getBulkUpload'))->withFailures($studentImport->failures());
        }
        Storage::delete($path);
        return redirect(route('hosStudents.index'))->with('success', 'Student Uploaded Successfully');


    }
}
