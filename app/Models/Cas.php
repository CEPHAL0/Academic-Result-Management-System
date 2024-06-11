<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cas extends Model
{
    use HasFactory;

protected $fillable = [
        "student_id",
        "assignment_id",
        "mark",
        "remarks"
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, "student_id");
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, "assignment_id");
    }

//    public function calculateTotalMarksPerSubjectTeacherWithWeightage($subjectTeacherId, $studentId)
//    {
//        $casRecords = Cas::whereHas("assignment.subjectTeacher", function ($query) use ($subjectTeacherId) {
//            $query->where("teacher_id", $subjectTeacherId);
//        })
//            ->where('student_id', $studentId)
//            ->with('assignment.casType')
//            ->get();
//
//        $totalMarksByCasType = [];
//
//        foreach ($casRecords as $cas) {
//            $casType = $cas->assignment->casType;
//            $totalMarksByCasType[$casType->id] = isset($totalMarksByCasType[$casType->id]) ?
//                $totalMarksByCasType[$casType->id] + $cas->mark :
//                $cas->mark;
//        }
//
//        $totalWeightedMarks = 0;
//        foreach ($totalMarksByCasType as $casTypeId => $totalMarks) {
//            $casType = CasType::findOrFail($casTypeId);
//            $weightage = $casType->weightage;
//
//            $totalWeightedMarks += ($totalMarks ) * ($weightage/100);
//
//        }
//
//        return $totalWeightedMarks;
//    }
//        Below function is to calculate the average weightage marks


    public static function calculateTotalMarksPerSubjectTeacher($subjectId, $studentId, $startDate, $endDate)
    {
        $casRecords = Cas::whereHas("assignment.subjectTeacher.subject", function ($query) use ($subjectId) {
            $query->where("subject_id", $subjectId);
        })
            ->where('student_id', $studentId)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with('assignment.casType')
            ->get();
        $casTypeStats = [];

        foreach ($casRecords as $cas) {
            $casTypeId = $cas->assignment->casType->id;
            $casTypeStats[$casTypeId]['totalMarks'] = isset($casTypeStats[$casTypeId]['totalMarks']) ?
                $casTypeStats[$casTypeId]['totalMarks'] + $cas->mark :
                $cas->mark;
            $casTypeStats[$casTypeId]['count'] = isset($casTypeStats[$casTypeId]['count']) ?
                $casTypeStats[$casTypeId]['count'] + 1 :
                1;
        }

        $averageMarksPerCasType = [];
        foreach ($casTypeStats as $casTypeId => $stats) {
            $averageMarksPerCasType[$casTypeId] = $stats['totalMarks'] / $stats['count'];
        }

        return array_sum($averageMarksPerCasType);
    }

    public static function gradeConversion(Subject $subject, int $mark){
        $school = $subject->grade->school;
        $cas = $school->cas_weightage ?? null;

        if ($cas === null) {
            return "No CAS weightage found for the school";
        }

        $conversion = $cas / 100;

        if ($subject->type == "ECA"){
            $gradeBoundaries = [
                40 => "Exceptional",
                30 => "More Than Satisfactory",
                25 => "Satisfactory",
                20 => "Need Improvement",
                0 => "Not Acceptable",
            ];
        } else {
            $gradeBoundaries = [
                90 => "A+",
                80 => "A",
                70 => "B+",
                60 => "B",
                50 => "C+",
                40 => "C",
                35 => "D",
            ];
        }

        foreach ($gradeBoundaries as $boundary => $grade) {
            if ($mark >= $boundary * $conversion) {
                return $grade;
            }
        }

        return "NG";
    }

    public static function gradePoint(Subject $subject, int $mark){
        $school = $subject->grade->school;
        $cas = $school->cas_weightage ?? null;

        if ($cas === null) {
            return "No CAS weightage found for the school";
        }

        $conversion = $cas / 100;

        if ($subject->type == "ECA"){
            $gradeBoundaries = [
                40 => "Exceptional",
                30 => "More Than Satisfactory",
                25 => "Satisfactory",
                20 => "Need Improvement",
                0 => "Not Acceptable",
            ];
        } else {
            $gradeBoundaries = [
                90 => 4,
                80 => 3.6,
                70 => 3.2,
                60 => 2.8,
                50 => 2.4,
                40 => 2,
                35 => 1.6,
            ];
        }

        foreach ($gradeBoundaries as $boundary => $grade) {
            if ($mark >= $boundary * $conversion) {
                return $grade;
            }
        }

        return "NG";
    }
}
