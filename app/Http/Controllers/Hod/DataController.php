<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Cas;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class DataController extends Controller
{
    //
    public function dataIndex()
    {
        $assignmentCountsBySubject = $this->getAssignmentCountsBySubjects();
        $assignmentAverageMarksBySubject = $this->getAssignmentAverageMarksBySubject();

        $examAverageMarksBySubject = $this->getExamAverageMarksBySubjects();
        $examCountsBySubject = $this->getExamCountsBySubjects();

        return view("hod.dashboard.dataIndex", compact("assignmentCountsBySubject", "assignmentAverageMarksBySubject", "examAverageMarksBySubject", "examCountsBySubject"));
    }


    public function getAssignmentCountsBySubjects()
    {
        $teacherId = auth()->id();

        $subjects = Subject::whereHas("department", function ($query) use ($teacherId) {
            return $query->where("head_of_department_id", $teacherId);
        })->get();

        $assignmentCountData[] = ["Subject", "Assignment Count"];

        foreach ($subjects as $key => $subject) {

            $assignmentCounts = Assignment::whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                return $query->where("id", $subject->id);
            })->get()->count();

            $assignmentCountData[$key + 1] = [$subject->grade->name . " " . $subject->name, $assignmentCounts];

        }

        return json_encode($assignmentCountData);

    }


    public function getExamCountsBySubjects()
    {
        $teacherId = auth()->id();

        $subjects = Subject::whereHas("department", function ($query) use ($teacherId) {
            return $query->where("head_of_department_id", $teacherId);
        })->get();

        $examCountData[] = ["Subject", "Exam Count"];

        foreach ($subjects as $key => $subject) {

            $examCount = Exam::whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                return $query->where("id", $subject->id);
            })->get()->count();

            $examCountData[$key + 1] = [$subject->grade->name . " " . $subject->name, $examCount];
        }

        return json_encode($examCountData);

    }

    public function getExamAverageMarksBySubjects()
    {
        $teacherId = auth()->id();

        $subjects = Subject::whereHas("department", function ($query) use ($teacherId) {
            return $query->where("head_of_department_id", $teacherId);
        })->get();

        $examAverageData[] = ["Subject", "Exam Average"];

        foreach ($subjects as $key => $subject) {

            $examAverage = Exam::whereHas("subjectTeacher.subject", function ($query) use ($subject) {
                return $query->where("id", $subject->id);
            })->get()->avg('mark');

            $examAverageData[$key + 1] = [$subject->grade->name . " " . $subject->name, $examAverage];
        }

        return json_encode($examAverageData);

    }


    public function getAssignmentAverageMarksBySubject()
    {
        $teacherId = auth()->id();

        $subjects = Subject::whereHas("department", function ($query) use ($teacherId) {
            return $query->where("head_of_department_id", $teacherId);
        })->get();


        $assignmentAverageData[] = ["Subject", "Assignment Average"];

        foreach ($subjects as $key => $subject) {

            $casAverage = Cas::whereHas("assignment.subjectTeacher.subject", function ($query) use ($subject) {
                return $query->where("id", $subject->id);
            })->get()->avg('mark');

            $assignmentAverageData[$key + 1] = [$subject->grade->name . " " . $subject->name, $casAverage];

        }

        return json_encode($assignmentAverageData);

    }
}
