<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Section;
use App\Models\StudentSection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
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
            "status" => fake()->randomElement(["ACTIVE", "DROPPED_OUT"]),
            "emis_no" => fake()->unique()->numberBetween(3000, 4000),
            "reg_no" => fake()->unique()->numberBetween(200000, 300000),
            "image" => "test.jpg",
            "section_id" => $this->getRandomSectionId(),
            "fathers_profession" => fake()->jobTitle(),
            "mothers_profession" => fake()->jobTitle(),
            "guardians_profession" => fake()->jobTitle(),
        ];
    }




    private function getRandomSectionId()
    {
        return Section::inRandomOrder()->first()->id;
    }
}
