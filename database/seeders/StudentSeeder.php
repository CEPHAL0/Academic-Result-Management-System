<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = Section::all();
        foreach ($sections as $section) {
            for ($i = 0; $i < 10; $i++) {
                Student::create([
                    "name" => fake()->name(),
                    "roll_number" => fake()->unique()->numberBetween(1000, 2000),
                    "date_of_birth" => fake()->date(),
                    "father_name" => fake()->name(),
                    "father_contact" => fake()->phoneNumber(),
                    "mother_name" => fake()->name(),
                    "mother_contact" => fake()->phoneNumber(),
                    "guardian_name" => fake()->name(),
                    "guardian_contact" => fake()->phoneNumber(),
                    "email" => fake()->email(),
                    "status" => "ACTIVE",
                    "emis_no" => fake()->unique()->numberBetween(3000, 4000),
                    "reg_no" => fake()->unique()->numberBetween(200000, 300000),
                    "image" => "test.jpg",
                    "section_id" => $section->id,
                    "fathers_profession" => fake()->jobTitle(),
                    "mothers_profession" => fake()->jobTitle(),
                    "guardians_profession" => fake()->jobTitle(),
                ]);
            }
        }
    }
}