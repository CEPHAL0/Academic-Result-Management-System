<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\School;
use App\Models\SubjectTeacher;
use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $subjectTeachers = SubjectTeacher::all();


        $schools = School::all();

        foreach ($schools as $school) {


            $casTypes = $school->casTypes;
            $grades = $school->grades;


            foreach ($grades as $grade) {
                foreach ($casTypes as $casType) {
                    $terms = $grade->terms;
                    foreach ($terms as $term) {
                        $sections = $term->grade->sections;
                        foreach ($sections as $section) {
                            $subjectTeachers = $section->subjectTeachers;

                            foreach ($subjectTeachers as $subjectTeacher) {
                                Assignment::create([
                                    "name" => "Week " . fake()->randomNumber(2, false),

                                    "date_assigned" => date_add(date_create($term->start_date), date_interval_create_from_date_string("10 days")),
                                    "subject_teacher_id" => $subjectTeacher->id,
                                    "description" => "This is a great assignment",
                                    "cas_type_id" => $casType->id,
                                    "term_id" => $term->id,
                                    "submitted" => "1"

                                ]);
                            }
                        }
                    }

                }


            }
        }



   
    }
}
