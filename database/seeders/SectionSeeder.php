<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $grades = Grade::all();

        foreach ($grades as $grade) {

            $sections = ['A', 'B'];

            foreach ($sections as $sectionName) {
                Section::create([
                    "name" => $grade->name . $sectionName,
                    "grade_id" => $grade->id,
                    "class_teacher_id" => $this->getClassTeacher()
                ]);
            }
        }
    }

    private function getClassTeacher()
    {
        return User::inRandomOrder()->first()->id;
    }
}