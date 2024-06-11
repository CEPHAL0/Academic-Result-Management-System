<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Student;
use App\Models\StudentExam;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $subjectTeachers = SubjectTeacher::all();

        $students = Student::all();

        foreach ($students as $student) {
            StudentExam::create([
                "student_id" => $student->id,
                "symbol_no" => $student->roll_number
            ]);
        }

        // $subjects = Subject::all();

        // foreach ($subjects as $subject) {


        //     $subjectTeacher = SubjectTeacher::where("subject_id", $subject->id)->first();

        //     $studentExams = StudentExam::whereHas("student.section.grade", function ($query) use ($subjectTeacher) {
        //         return $query->where("id", $subjectTeacher->subject->grade_id);
        //     })->get();

        //     foreach ($studentExams as $studentExam) {
        //         Exam::create([
        //             "student_exam_id" => $studentExam->id,
        //             "term_id" => 1,
        //             "subject_teacher_id" => $subjectTeacher->id,
        //             "mark" => fake()->numberBetween(0, $studentExam->student->section->grade->school->theory_weightage),
        //         ]);
        //     }
        // }

        $terms = Term::all();

        foreach ($terms as $term) {
            $subjects = $term->grade->subjects;


            foreach ($subjects as $subject) {

                $subjectTeacher = SubjectTeacher::where("subject_id", $subject->id)->first();



                $students = Student::whereHas("section.grade", function ($query) use ($subjectTeacher) {
                    return $query->where("id", $subjectTeacher->subject->grade_id);
                })->get();


                foreach ($students as $student) {
                    $studentExam = StudentExam::where("student_id", $student->id)->firstOrFail();

                    Exam::create([
                        "student_exam_id" => $studentExam->id,
                        "term_id" => $term->id,
                        "subject_teacher_id" => $subjectTeacher->id,
                        "mark" => fake()->numberBetween(0, $student->section->grade->school->theory_weightage),

                    ]);
                }
            }
        }



    }
}