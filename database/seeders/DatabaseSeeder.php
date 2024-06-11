<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            // TeacherSeeder::class,
            // UserRoleSeeder::class,
            // SchoolSeeder::class,
            // GradeSeeder::class,
            // SectionSeeder::class,
            // SectionSeederFake::class,
            // DepartmentSeeder::class,
            // StudentSeeder::class,
            // TermSeeder::class,
            // SubjectSeeder::class,
            // SubjectTeacherSeeder::class,
            // CasTypeSeeder::class,
            // AssignmentSeeder::class,
            // CasSeeder::class,
            // ExamSeeder::class,

        ]);
    }
}
