<?php

namespace Database\Seeders;

use App\Models\CasType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\School;

class CasTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $casTypes = ["Essential Skill", "Homework", "Project Work", "Classwork", "Monthly Test"];

        $schools = School::all();

        foreach ($schools as $school) {
            foreach ($casTypes as $casType) {
                CasType::create([
                    "name" => $casType,
                    "school_id" => $school->id,
                    "full_marks" => 20,
                    "weightage" => 20,
                ]);
            }
        }
    }
}
