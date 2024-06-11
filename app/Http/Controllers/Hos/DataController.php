<?php

namespace App\Http\Controllers\Hos;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Cas;
use App\Models\CasType;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\School;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    //

    public function dataIndex()
    {
        try {

            $teacherId = auth()->id();

            $latestAssignment = Assignment::latest()->firstOrFail();

            $termId = $latestAssignment->term_id;

            $assignmentCountData = $this->getAssignmentCountData();

            $assignmentCountByGrade = $this->getAssignmentCountsByGrade();

            $averageCasMarksBySubject = $this->getAverageCasMarksBySubject();

            $averageExamMarksBySubject = $this->getAverageExamMarksBySubject();

            $averageOverallMarksBySection = $this->getAverageOverallMarksBySection();




            $terms = Term::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy('grade.name');

            $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy('name');

            $students = Student::whereHas("section.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get()->sortBy("roll_number");



            return view("hos.dashboard.dataIndex", compact("assignmentCountData", "terms", "assignmentCountByGrade", "averageCasMarksBySubject", "grades", "averageExamMarksBySubject", "averageOverallMarksBySection", "students"));
        } catch (Exception $e) {
            return redirect(route("hosDashboard.index"));
        }
    }


    public function filterTermAssignmentCount(Request $request)
    {
        return $this->getAssignmentCountData($request->term_id);
    }

    public function filterTermAssignmentCountByGrade(Request $request)
    {
        return $this->getAssignmentCountsByGrade($request->term_id);
    }

    public function filterTermAssignmentAverageBySubject(Request $request)
    {
        return $this->getAverageCasMarksBySubject($request->term_id);
    }

    public function filterTermExamAverageBySubject(Request $request)
    {
        return $this->getAverageExamMarksBySubject($request->term_id);
    }

    public function filterTermOverallAverageBySection(Request $request)
    {
        return $this->getAverageOverallMarksBySection($request->term_id);
    }

    public function filterStudentAverageAssignmentBySubjectTeacher(Request $request)
    {
        return $this->getStudentAverageAssignmentBySubjectTeacher($request->student_id);
    }

    public function filterStudentAverageExamBySubjectTeacher(Request $request)
    {
        return $this->getStudentAverageExamBySubjectTeacher($request->student_id);
    }





    public function getAssignmentCountData(int $termId = null)
    {
        $teacherId = auth()->id();


        $casTypes = CasType::whereHas("school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->get();




        $assignmentCountData[] = ["Cas Type", "Assignment Count"];

        foreach ($casTypes as $key => $casType) {

            if ($termId != null) {
                $assignmentCount = Assignment::where("cas_type_id", $casType->id)->where("term_id", $termId)->count();
            } else {

                $latestAssignment = Assignment::latest("updated_at")->whereHas("casType.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->first();

                $assignmentCount = Assignment::where("cas_type_id", $casType->id)->where("term_id", $latestAssignment->term_id)->count();
            }

            $assignmentCountData[$key + 1] = [$casType->name, $assignmentCount];
        }

        $assignmentCountData = json_encode($assignmentCountData);

        return $assignmentCountData;

    }


    public function getAssignmentCountsByGrade(int $termId = null)
    {
        $teacherId = auth()->id();

        $grades = Grade::whereHas("school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->get()->sortBy("name");



        $assignments = Assignment::whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->where("term_id", $termId)->get();

        $assignmentCounts[] = ["Grade", "Assignment Count"];

        foreach ($grades as $key => $grade) {

            if ($termId != null) {
                $assignmentCount = Assignment::whereHas("subjectTeacher.subject.grade", function ($query) use ($grade) {
                    return $query->where("id", $grade->id);
                })->where("term_id", $termId)->count();

                $assignmentCounts[$key + 1] = [$grade->name, $assignmentCount];
            } else {
                $assignmentCount = Assignment::whereHas("subjectTeacher.subject.grade", function ($query) use ($grade) {
                    return $query->where("id", $grade->id);
                })->count();

                $assignmentCounts[$key + 1] = [$grade->name, $assignmentCount];
            }
        }

        return json_encode($assignmentCounts);
    }


    public function getAverageCasMarksBySubject(int $termId = null)
    {
        $teacherId = auth()->id();



        $subjects = Subject::whereHas("grade.school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->get();



        $averageMarks[] = ["Subject", "Average Mark"];

        foreach ($subjects as $key => $subject) {

            if ($termId != null) {

                $casAverage = Cas::whereHas("assignment.subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("assignment.subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->whereHas("assignment", function ($query) use ($termId) {
                    return $query->where("term_id", $termId);
                })->get()->avg('mark');

                if ($casAverage == null) {
                    $casAverage = 0;
                }


                $averageMarks[$key + 1] = [$subject->grade->name . "-" . $subject->name, $casAverage];

            } else {
                $casAverage = Cas::whereHas("assignment.subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("assignment.subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->get()->avg('mark');

                if ($casAverage == null) {
                    $casAverage = 0;
                }

                $averageMarks[$key + 1] = [$subject->grade->name . "-" . $subject->name, $casAverage];
            }
        }



        return json_encode($averageMarks);
    }


    public function getAverageExamMarksBySubject(int $termId = null)
    {
        $teacherId = auth()->id();



        $subjects = Subject::whereHas("grade.school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->get();



        $averageMarks[] = ["Subject", "Average Mark"];

        foreach ($subjects as $key => $subject) {

            if ($termId != null) {

                $examAverage = Exam::whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->where("term_id", $termId)->get()->avg('mark');

                if ($examAverage == null) {
                    $examAverage = 0;
                }


                $averageMarks[$key + 1] = [$subject->grade->name . "-" . $subject->name, $examAverage];

            } else {
                $examAverage = Exam::whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                    return $query->where("id", $subject->id);
                })->get()->avg('mark');

                if ($examAverage == null) {
                    $examAverage = 0;
                }

                $averageMarks[$key + 1] = [$subject->grade->name . "-" . $subject->name, $examAverage];
            }
        }



        return json_encode($averageMarks);
    }


    public function getAverageOverallMarksBySection(int $termId = null)
    {
        $teacherId = auth()->id();



        $sections = Section::whereHas("grade.school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->get();



        $averageMarks[] = ["Section", "Average Assignment Mark", "Average Exam Mark"];

        foreach ($sections as $key => $section) {

            if ($termId != null) {

                $examAverage = Exam::whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("subjectTeacher.section", function ($query) use ($section) {
                    return $query->where("id", $section->id);
                })->where("term_id", $termId)->get()->avg('mark');


                $casAverage = Cas::whereHas("assignment.subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("assignment.subjectTeacher.section", function ($query) use ($section) {
                    return $query->where("id", $section->id);
                })->whereHas("assignment", function ($query) use ($termId) {
                    return $query->where("term_id", $termId);
                })->get()->avg('mark');

                if ($examAverage == null) {
                    $examAverage = 0;
                }

                if ($casAverage == null) {
                    $casAverage = 0;
                }


                $averageMarks[$key + 1] = [$section->name, $casAverage, $examAverage];

            } else {
                $examAverage = Exam::whereHas("subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("subjectTeacher.section", function ($query) use ($section) {
                    return $query->where("id", $section->id);
                })->get()->avg('mark');


                $casAverage = Cas::whereHas("assignment.subjectTeacher.subject.grade.school", function ($query) use ($teacherId) {
                    return $query->where("head_of_school_id", $teacherId);
                })->whereHas("assignment.subjectTeacher.section", function ($query) use ($section) {
                    return $query->where("id", $section->id);
                })->get()->avg('mark');

                if ($examAverage == null) {
                    $examAverage = 0;
                }

                if ($casAverage == null) {
                    $casAverage = 0;
                }

                $averageMarks[$key + 1] = [$section->name, $casAverage, $examAverage];
            }
        }



        return json_encode($averageMarks);
    }


    public function getStudentAverageAssignmentBySubjectTeacher(int $studentId = null)
    {

        $teacherId = auth()->id();

        if ($studentId == null) {
            return " ";
        }

        $student = Student::where("id", $studentId)->whereHas("section.grade.school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->firstOrFail();


        $latestAssignment = Assignment::latest();




        $subjectTeachers = $student->section->subjectTeachers;

        $averageMarks[] = ["Subject Teacher", "Assignment Marks"];

        foreach ($subjectTeachers as $key => $subjectTeacher) {

            $casAverage = Cas::whereHas("assignment.subjectTeacher", function ($query) use ($subjectTeacher) {
                return $query->where("id", $subjectTeacher->id);
            })->where("student_id", $studentId)->get()->avg('mark');

            if ($casAverage == null) {
                $casAverage = 0;
            }

            $averageMarks[$key + 1] = [$subjectTeacher->subject->name, $casAverage];
        }

        return json_encode($averageMarks);
    }


    public function getStudentAverageExamBySubjectTeacher(int $studentId)
    {
        $teacherId = auth()->id();

        if ($studentId == null) {
            return " ";
        }

        $student = Student::where("id", $studentId)->whereHas("section.grade.school", function ($query) use ($teacherId) {
            return $query->where("head_of_school_id", $teacherId);
        })->firstOrFail();



        $subjectTeachers = $student->section->subjectTeachers;

        $averageMarks[] = ["Subject Teacher", "Assignment Marks"];

        foreach ($subjectTeachers as $key => $subjectTeacher) {

            $examAverage = Exam::whereHas("subjectTeacher", function ($query) use ($subjectTeacher) {
                return $query->where("id", $subjectTeacher->id);
            })->whereHas("studentExam.student", function ($query) use ($studentId) {
                return $query->where("id", $studentId);
            })->get()->avg('mark');

            if ($examAverage == null) {
                $examAverage = 0;
            }

            $averageMarks[$key + 1] = [$subjectTeacher->subject->name, $examAverage];
        }

        return json_encode($averageMarks);

    }



    public function studentProfilerView()
    {
        try {
            $teacherId = auth()->id();
            $students = Student::whereHas("section.grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->where("status", "ACTIVE")->get()->sortBy("roll_number");

            $subjects = Subject::whereHas("grade.school", function ($query) use ($teacherId) {
                return $query->where("head_of_school_id", $teacherId);
            })->get();


            return view("hos.dashboard.dataProfiler", compact("students", "subjects"));

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->withErrors(["Error", "Failed to retrieve data"]);
        }
    }





    // Profiler Controllers for data and AJAX request
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
        $studentId = $request->student_id;
        $student = Student::findOrFail($studentId);

        $subjects = Subject::whereHas("grade", function ($query) use ($student) {
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

        $subjects = Subject::whereHas("grade", function ($query) use ($student) {
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

        $subjects = Subject::whereHas("grade", function ($query) use ($student) {
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