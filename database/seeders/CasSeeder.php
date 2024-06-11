<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Cas;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        //
        $assignments = Assignment::all();

        foreach ($assignments as $assignment) {
            $students = $assignment->subjectTeacher->section->students;

            foreach ($students as $student) {
                Cas::create([
                    "student_id" => $student->id,
                    "assignment_id" => $assignment->id,
                    "mark" => fake()->numberBetween(0, $assignment->casType->full_marks),
                    "remarks" => "Great job"
                ]);
            }
        }
    }

    private function getRandomStudentId()
    {
        return Student::inRandomOrder()->first()->id;
    }

    private function getRandomAssignmentId()
    {
        return Assignment::inRandomOrder()->first()->id;
    }
}
