<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Section;
use App\Models\User;

class SectionSeederFake extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = Grade::all();
        $sections = ["A", "B"];
        foreach ($grades as $grade) {
            foreach ($sections as $section) {
                Section::create([
                    "name" => "" . $grade->name . "" . $section,
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
