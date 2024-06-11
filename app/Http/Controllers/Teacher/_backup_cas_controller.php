<?php

namespace App\Http\Controllers;

use Exception;

use App\Http\Requests\CasRequest;
use App\Http\Requests\CasStoreRequest;
use Illuminate\Http\Request;

use App\Models\Cas;
use App\Models\CasType;
use App\Models\Assignment;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentSection;
use App\Models\SubjectTeacher;
use App\Models\Term;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $teacher_id = auth()->id();
        $cas = Cas::whereHas("assignment.subjectTeacher", function ($query) use ($teacher_id) {
            $query->where("teacher_id", $teacher_id);
        })->get();
        return view("teacher.cas.index")->with(compact("cas"));
    }

    public function create(int $subjectTeacherId)
    {
        try {
            $date = Carbon::now()->toDateString();
            $teacher_id = auth()->id();

            // Retrieving the subjectTeacher and also checking if the subjectTeacher is assigned to the auth user
            $subjectTeacher = SubjectTeacher::where("id", $subjectTeacherId)->where("teacher_id", $teacher_id)->first();

            $casTypes = CasType::whereHas("school.grades", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->section->grade->id);
            })->get();

            $term = Term::whereHas("grade", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->subject->grade_id);
            })->where("start_date", "<=", $date)->where("end_date", ">", $date)->first();

            $students = Student::whereHas("studentSection.section.subjectTeachers", function ($query) use ($subjectTeacher) {
                $query->where("teacher_id", $subjectTeacher->teacher_id);
            })->get()->sortBy("roll_number");

            return view("admin.cas.create", compact("subjectTeacher", "term", "students", "casTypes"));
        } catch (Exception $e) {
            // Authenticated teacher doesnot have the subject Teacher assigned passed in URL
            return redirect()->back()->withErrors(["error", $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CasStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $assignment = Assignment::create([
                "name" => $data['assignment_name'],
                "date_assigned" => $data["date_assigned"],
                "subject_teacher_id" => $data["subjectTeacher"],
                "full_marks" => $data["full_marks"],
                "cas_type_id" => $data["cas_type"],
                "term_id" => $data["term_id"]
            ]);

            $subjectTeacher = SubjectTeacher::findOrFail($data["subjectTeacher"]);


            $section = Section::whereHas("subjectTeachers", function ($query) use ($subjectTeacher) {
                $query->where("id", $subjectTeacher->id);
            })->first();




            DB::beginTransaction();
            foreach ($data["students"] as $id => $student) {
                $studentSection = StudentSection::where("student_id", $student)->where("section_id", $section->id)->first();

                CAS::create([
                    "student_section_id" => $studentSection->id,
                    "assignment_id" => $assignment->id,
                    "mark" => $data["marks"][$id],
                    "remarks" => ""
                ]);
            }
            DB::commit();

            return redirect()->route("cas.index")->with("success", "Successfully created CAS");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to create cas marks: " . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {

        $cas = Cas::findOrFail($id);
        $teacher_id = auth()->id();

        $assignments = Assignment::whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id) {
            $query->where("id", $teacher_id);
        })->get();

        $students = Student::whereHas("studentSection.section.subjectTeachers", function ($query) use ($teacher_id) {
            $query->where("teacher_id", $teacher_id);
        })->get()->sortBy('name');

        return view("admin.cas.edit")->with(compact("cas", "assignments", "students"));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CasRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $cas = Cas::findOrFail($id);
            $cas->update($data);

            return redirect(route("cas.index"))->with("success", "Successfuly updated the cas value");
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(["errors" => "Failed to edit cas marks: " . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cas = Cas::findOrFail($id);

            $cas->delete();

            return redirect(route("cas.index"))->with("success", "Successfuly deleted the cas value");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(["errors" => "Failed to delete cas marks: " . $e->getMessage()]);
        }
    }

    // todo: Query for reference
    // $terms = Term::whereHas("assignments.subjectTeacher.teacher", function ($query) use ($user) {
    //             $query->where("id", $user->id);
    //         })->get();

    //     $latestCas = Cas::latest()->whereHas("assignment.subjectTeacher.teacher", function ($query) use ($teacher_id) {
    //         $query->where("id", $teacher_id);
    //     })->first();

    public function fetchData()
    {
        $teacher_id = auth()->id();

        $students = Student::whereHas("studentSection.section.subjectTeachers", function ($query) use ($teacher_id) {
            $query->where("teacher_id", $teacher_id);
        })->get();

        $subjectTeachers = SubjectTeacher::where("teacher_id", $teacher_id)->get();

        return $students->json();
    }


    public function reportIndex()
    {
        dd("Hello");
        $teacher_id = auth()->id();

        $latestCas = Cas::latest()
            ->whereHas("assignment.subjectTeacher.teacher", function ($query) use ($teacher_id) {
                $query->where("id", $teacher_id);
            })
            ->first();

        if (!$latestCas) {
            $assignments = [];
            $students = [];
        } else {
            $assignments = Assignment::whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id, $latestCas) {
                $query->where("id", $teacher_id)->where("subject_teacher_id", $latestCas->assignment->subjectTeacher->id);
            })
                ->get();


            $section = $latestCas->assignment->subjectTeacher->section;
            $students = $section->students;
        }

        $subjectTeachers = SubjectTeacher::where("teacher_id", $teacher_id)->get();

        $allStudents = Student::whereHas("section.subjectTeachers.teacher", function ($query) use ($teacher_id) {
            $query->where("id", $teacher_id);
        })->get();



        return view("admin.cas.report.index", compact("assignments", "students", "allStudents", "subjectTeachers"));
    }

    public function reportSearch(Request $request)
    {
        $teacher_id = auth()->id();
        if ($request->subject_teacher_id != null) {
            $subjectTeacher = SubjectTeacher::findOrFail($request->subject_teacher_id);

            $assignments = Assignment::where("subject_teacher_id", $subjectTeacher->id)->get();

            $students = $subjectTeacher->section->students;
        } else {
            $assignments = [];
            $students = [];
        }

        if ($request->student_id != null) {

            if ($request->subject_teacher_id == null) {
                $assignments = Assignment::whereHas("subjectTeacher.teacher", function ($query) use ($teacher_id) {
                    $query->where("id", $teacher_id);
                })->get();
            }

            // Adding as an element of an array because there is a loop iteration used in the blade template
            $students = [Student::findOrFail($request->student_id)];
        }

        if (($request->student_id == null) && ($request->subject_teacher_id == null)) {
            return redirect()->route('cas.reportIndex');
        }

        $subjectTeachers = SubjectTeacher::where("teacher_id", $teacher_id)->get();

        $allStudents = Student::whereHas("section.subjectTeachers.teacher", function ($query) use ($teacher_id) {
            $query->where("id", $teacher_id);
        })->get();


        return view("admin.cas.report.index", compact("assignments", "students", "allStudents", "subjectTeachers"));
    }
}

