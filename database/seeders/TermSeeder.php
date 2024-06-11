<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Term;
use App\Models\Grade;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // $numberOfTerms = 3;
        // $names = ["First Term", "Second Term", "Third Term", "Final Term"];

        // for ($i = 0; $i < $numberOfTerms; $i++) {
        //     Term::create([
        //         "name" => collect($names)->random(),
        //         "start_date" => fake()->date(),
        //         "end_date" => fake()->date(),
        //         "grade_id" => $this->getRandomGradeId(),
        //     ]);
        // }

        $grades = Grade::all();

        foreach ($grades as $grade) {
            Term::create([

                "name" => "First",

                "start_date" => "2024-01-01",
                "end_date" => "2024-03-31",
                "result_date" => "2024-04-10",
                "grade_id" => $grade->id

            ]);

            Term::create([
                "name" => "Second",
                "start_date" => "2024-04-11",
                "end_date" => "2024-07-31",
                "result_date" => "2024-07-31",
                "grade_id" => $grade->id

            ]);
        }
    }

    private function getRandomGradeId()
    {
        return Grade::inRandomOrder()->first()->id;
    }
}
