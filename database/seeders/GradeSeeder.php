<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\School;
use Carbon\Carbon;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming you have a school with ID 1, change accordingly
        $numberOfGrades = 12;

        // Insert grades with random end dates
        for ($i = 1; $i <= $numberOfGrades; $i++) {
            $grade = $this->getGradeCategory($i);
            $school = School::find($grade);

            Grade::create([
                'name' => (string) $i,
                'school_id' => $school->id,
            ]);
        }
    }

    /**
     * Get a random end date for the grade.
     *
     * @return string
     */
    private function getRandomEndDate()
    {
        // Set a random date within the next 5 years from now
        return Carbon::now()->addDays(rand(1, 1825))->toDateString();
    }

    /**
     * Determine the grade category (elementary, middle, high school) based on the grade number.
     *
     * @param int $gradeNumber
     * @return string
     */
    private function getGradeCategory($gradeNumber)
    {
        if ($gradeNumber >= 1 && $gradeNumber <= 4) {
            return 1;
        } elseif ($gradeNumber >= 5 && $gradeNumber <= 8) {
            return 2;
        } elseif ($gradeNumber >= 9 && $gradeNumber <= 12) {
            return 3;
        }
    }
}
