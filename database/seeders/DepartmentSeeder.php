<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Department;
use App\Models\User;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $names = ["Mathematics", "Science", "English", "Sports", "Nepali", "Music"];

        $names = ["Mathematics", "Science"];

        foreach ($names as $name) {
            Department::create([
                "name" => $name,
                "head_of_department_id" => $this->getRandomUserId(),
            ]);
        }
    }

    private function getRandomUserId()
    {
        return User::whereHas("roles", function ($query) {
            $query->where("name", "hod");
        })->inRandomOrder()->first()->id;
    }
}
