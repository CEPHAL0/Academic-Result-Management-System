<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\User;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert three schools with specific data
        School::create([
            'name' => 'Elementary School',
            'head_of_school_id' => $this->getRandomUserId(),
            'theory_weightage' => 25,
            'cas_weightage' => 75,
        ]);

        School::create([
            'name' => 'Middle School',
            'head_of_school_id' => $this->getRandomUserId(),
            'theory_weightage' => 50,
            'cas_weightage' => 50,
        ]);

        School::create([
            'name' => 'High School',
            'head_of_school_id' => $this->getRandomUserId(),
            'theory_weightage' => 75,
            'cas_weightage' => 25,
        ]);
    }

    /**
     * Get a random user ID.
     *
     * @return int
     */
    private function getRandomUserId()
    {
        return User::whereHas("roles", function ($query) {
            $query->where("name", "hos");
        })->inRandomOrder()->first()->id;
    }
}
