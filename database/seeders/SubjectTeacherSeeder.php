<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Section;
use App\Models\Subject;
use App\Models\SubjectTeacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = Grade::all();

        foreach ($grades as $grade) {
            $subjects = Subject::where("grade_id", $grade->id)->get();
            foreach ($subjects as $subject) {
                $sections = Section::where("grade_id", $grade->id)->get();
                foreach ($sections as $section) {
                    SubjectTeacher::create([
                        "subject_id" => $subject->id,
                        "teacher_id" => $this->getRandomTeacherId($section->name),
                        "section_id" => $section->id,
                    ]);
                }


            }


        }
    }

    private function getRandomSubject()
    {
        return Subject::inRandomOrder()->first();
    }

    private function getRandomTeacherId($sectionName)
    {
        $section = substr($sectionName, -1);
        if ($section == "A")
            return User::where("id", 1)->first()->id;
        else if ($section == "B")
            return User::where("id", 2)->first()->id;
    }

    private function getRandomSection()
    {
        return Section::inRandomOrder()->first();
    }
}