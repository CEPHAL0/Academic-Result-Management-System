<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Cas;
use App\Models\CasType;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function studentProfilerView()
    {
        try {
            $teacherId = auth()->id();

            $students = Student::whereHas("section.subjectTeachers.teacher", function ($query) use ($teacherId) {
                return $query->where("id", $teacherId);
            })->where("status", "ACTIVE")->get()->sortBy("roll_number");

            $subjects = Subject::whereHas("grade.sections.subjectTeachers.teacher", function ($query) use ($teacherId) {
                return $query->where("id", $teacherId);
            })->get();

            return view("teacher.dashboard.dataProfiler", compact("students", "subjects"));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve data"]);
        }
    }



    public function getTermsForStudent(Request $request)
    {

        $studentId = $request->student_id;
        $student = Student::findOrFail($studentId);
        $terms = Term::whereHas("grade", function ($query) use ($student) {
            return $query->where("id", $student->section->grade_id);
        })->get()->sortBy("name");

        return json_encode($terms);
    }




    public function filterTermForStudentAssignmentData(Request $request)
    {
        $termId = $request->term_id;
        $term = Term::findOrFail($termId);

        $result = $this->getStudentAssignmentData($request, $term->id);
        return $result;
    }


    public function getStudentAssignmentData(Request $request, $termId = null)
    {
        $teacherId = auth()->id();
        $studentId = $request->student_id;
        $student = Student::findOrFail($studentId);

        $subjects = Subject::whereHas("subjectTeachers.teacher", function ($query) use ($teacherId) {
            return $query->where("id", $teacherId);
        })->whereHas("grade", function ($query) use ($student) {
            return $query->where("id", $student->section->grade_id);
        })->get()->sortBy("name");

        $subjectData = [];

        foreach ($subjects as $subject) {

            $assignments = Assignment::whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                return $query->where("id", $subject->id);
            })->whereHas("subjectTeacher.section", function ($query) use ($student) {
                return $query->where("id", $student->section_id);
            });


            if ($termId != null) {

                $term = Term::findOrFail($termId);

                $assignments = Assignment::whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->whereHas("subjectTeacher.section", function ($query) use ($student) {
                    return $query->where("id", $student->section_id);
                })->whereHas("term", function ($query) use ($term) {
                    return $query->where("id", $term->id);
                });
            }

            $assignments = $assignments->get()->sortBy("name");

            $assignmentsData = [["Assignment Name", "Marks %"]];

            foreach ($assignments as $assignment) {
                $casMark = Cas::where("assignment_id", $assignment->id)
                    ->where("student_id", $student->id)
                    ->first();

                $fullMark = $assignment->casType->full_marks;

                $casMark = $casMark ? (int) $casMark->mark / $fullMark * 100 : 0;

                $assignmentsData[] = [$assignment->name, $casMark];
            }


            $subjectName = $subject->name;
            $trimmedSubjectName = str_replace(' ', '', $subjectName);
            $trimmedSubjectCode = str_replace(' ', "", $subject->subject_code);
            $keyName = $trimmedSubjectName . "-" . $trimmedSubjectCode;
            $subjectData[$keyName] = $assignmentsData;
        }

        return json_encode($subjectData, JSON_NUMERIC_CHECK);
    }





    public function filterStudentAverageAssignmentMarksByCasTypeForEachSubjectByTerm(Request $request)
    {
        $termId = $request->term_id;
        $term = Term::findOrFail($termId);

        $result = $this->getStudentAverageAssignmentMarksByCasTypeForEachSubject($request, $term->id);
        return $result;
    }




    public function getStudentAverageAssignmentMarksByCasTypeForEachSubject(Request $request, $termId = null)
    {

        $teacherId = auth()->id();
        $studentId = $request->student_id;
        $student = Student::findOrFail($studentId);

        $casTypes = CasType::whereHas("school.grades", function ($query) use ($student) {
            return $query->where("id", $student->section->grade_id);
        })->get()->sortBy("name");

        $subjects = Subject::whereHas("subjectTeachers.teacher", function ($query) use ($teacherId) {
            return $query->where("id", $teacherId);
        })->whereHas("grade", function ($query) use ($student) {
            return $query->where("id", $student->section->grade_id);
        })->get()->sortBy("name");

        $subjectData = [];

        foreach ($subjects as $subject) {
            $casTypeData = [["Cas Type Name", "Marks %"]];

            foreach ($casTypes as $casType) {
                $averageMarks = Cas::where("student_id", $studentId)->whereHas("assignment.subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->whereHas("assignment.casType", function ($query) use ($casType) {
                    return $query->where("id", $casType->id);
                })->get()->avg("mark");

                if ($termId != null) {

                    $term = Term::findOrFail($termId);

                    $averageMarks = Cas::where("student_id", $studentId)->whereHas("assignment.subjectTeacher.subject", function ($query) use ($subject) {
                        return $query->where("id", $subject->id);
                    })->whereHas("assignment.casType", function ($query) use ($casType) {
                        return $query->where("id", $casType->id);
                    })->whereHas("assignment.term", function ($query) use ($term) {
                        return $query->where("id", $term->id);
                    })->get()->avg("mark");
                }

                $fullMark = $casType->weightage;

                $percentageMarks = ($averageMarks / $fullMark) * 100;

                $casTypeData[] = [$casType->name, (int) $percentageMarks];
            }
            $subjectName = $subject->name;
            $trimmedSubjectName = str_replace(' ', '', $subjectName);
            $trimmedSubjectCode = str_replace(' ', "", $subject->subject_code);
            $keyName = $trimmedSubjectName . "-" . $trimmedSubjectCode;
            $subjectData[$keyName] = $casTypeData;
        }

        return json_encode($subjectData);

    }






    public function getExamMarksForEachTerm(Request $request)
    {
        $teacherId = auth()->id();
        $studentId = $request->student_id;
        $student = Student::findOrFail($studentId);


        $terms = Term::whereHas("grade", function ($query) use ($student) {
            return $query->where("id", $student->section->grade_id);
        })->get();


        $subjects = Subject::whereHas("subjectTeachers.teacher", function ($query) use ($teacherId) {
            return $query->where("id", $teacherId);
        })->whereHas("grade", function ($query) use ($student) {
            return $query->where("id", $student->section->grade_id);
        })->get()->sortBy("name");

        $subjectData = [];

        foreach ($subjects as $subject) {
            $termData = [["Term Name", "Marks %"]];

            foreach ($terms as $term) {
                $examMarks = Exam::whereHas("studentExam.student", function ($query) use ($student) {
                    return $query->where("id", $student->id);
                })->where("term_id", $term->id)->whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->get()->avg("mark");

                $fullMark = $student->section->grade->school->theory_weightage;

                $percentageMarks = ($examMarks / $fullMark) * 100;

                $termData[] = [$term->name, (int) $percentageMarks];
            }

            $subjectName = $subject->name;
            $trimmedSubjectName = str_replace(' ', '', $subjectName);
            $trimmedSubjectCode = str_replace(' ', "", $subject->subject_code);
            $keyName = $trimmedSubjectName . "-" . $trimmedSubjectCode;
            $subjectData[$keyName] = $termData;
        }
        return json_encode($subjectData);
    }
}