<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $result = User::create([
            "name" => "Teacher",
            "password" => bcrypt("teacher"),
            "email" => "teacher@sifal.deerwalk.edu.np"
        ]);

        $teacher = Role::where("name", "teacher")->first();

        $result->roles()->attach($teacher->id, ["user_id" => $result->id]);
    }
}
