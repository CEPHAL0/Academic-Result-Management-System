<?php

namespace Database\Factories;

use App\Models\CasType;
use App\Models\SubjectTeacher;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
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
            "name" => fake()->catchPhrase(),
            "subject_teacher_id" => $this->getRandomSubjectTeacherId(),
            "date_assigned" => fake()->date(),
            "description" => fake()->realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2),
            "cas_type_id" => $this->getRandomCasTypeId(),
            "full_marks" => fake()->numberBetween(0, 100),
            "term_id" => $this->getRandomTermId(),
        ];
    }

    private function getRandomSubjectTeacherId()
    {
        return SubjectTeacher::inRandomOrder()->first()->id;
    }

    private function getRandomCasTypeId()
    {
        return CasType::inRandomOrder()->first()->id;
    }

    private function getRandomTermId()
    {
        return Term::inRandomOrder()->first()->id;
    }
}
