<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_exam_id",
        "term_id",
        "subject_teacher_id",
        "mark",
        "exam",
    ];


    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, "term_id");
    }

    public function subjectTeacher(): BelongsTo
    {
        return $this->belongsTo(SubjectTeacher::class, "subject_teacher_id");
    }

    public function studentExam(): BelongsTo
    {
        return $this->belongsTo(StudentExam::class, "student_exam_id");
    }

    public static function gradeConversion(Subject $subject, int $mark)
    {
        $theory = $subject->grade->school->theory_weightage;

        $conversion = $theory / 100;

        $gradeBoundaries = [
            90 => "A+",
            80 => "A",
            70 => "B+",
            60 => "B",
            50 => "C+",
            40 => "C",
            35 => "D",
        ];

        if (isset($conversion)) {
            foreach ($gradeBoundaries as $boundary => $grade) {
                if ($mark > $boundary * $conversion) {
                    return $grade;
                }
            }
            return "NG";
        } else {
            return "No theory weightage found for the school";
        }
    }

    public static function gradePoint(Subject $subject, int $mark)
    {
        $theory = $subject->grade->school->theory_weightage;

        $conversion = $theory / 100;

        $gradeBoundaries = [
            90 => 4,
            80 => 3.6,
            70 => 3.2,
            60 => 2.8,
            50 => 2.4,
            40 => 2,
            35 => 1.6,
        ];

        if (isset($conversion)) {
            foreach ($gradeBoundaries as $boundary => $grade) {
                if ($mark > $boundary * $conversion) {
                    return $grade;
                }
            }
            return "NG";
        } else {
            return "No theory weightage found for the school";
        }
    }


}
