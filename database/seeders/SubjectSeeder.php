<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Support\Arr;

class SubjectSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = Grade::all();

        foreach ($grades as $grade) {

            foreach ($this->types as $type) {
                $subjects = $this->getSubjectsForGrade($grade->name, $type);
                foreach ($subjects as $subjectName) {
                    Subject::create(
                        [
                            "name" => $subjectName,
                            "subject_code" => $this->generateSubjectCode($subjectName, $grade->name, $type),
                            "department_id" => $this->getRandomDepartmentId(),
                            "type" => $type,
                            "credit_hr" => fake()->randomFloat(2),
                            "grade_id" => $grade->id,
                        ]
                    );
                }
            }
        }

    }


    private function generateSubjectCode($subjectName, $gradeName, $typeName)
    {
        $subjectNameAbb = strtoupper(substr($subjectName, 0, 3));
        $subjectTypeAbb = strtoupper(substr($typeName, 0, 1));

        if ($gradeName == "10" || $gradeName == "11" || $gradeName == "12") {
            $subjectCode = $subjectNameAbb . "-" . $subjectTypeAbb . "-0" . $gradeName;
        } else {
            $subjectCode = $subjectNameAbb . "-" . $subjectTypeAbb . "-00" . $gradeName;
        }

        return $subjectCode;
    }



    private function getGrades()
    {
        $grades = Grade::all();
        $gradeId = [];

        foreach ($grades as $grade) {
            array_push($gradeId, $grade->id);
        }
        $randomGrades = Arr::random($gradeId, 2);
        return $randomGrades;
    }

    private function getRandomDepartmentId()
    {
        return Department::inRandomOrder()->first()->id;
    }


    private function getSubjectsForGrade($gradeName, $subjectType)
    {
        $subjects = [
            "1" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science',
                    'Hamro Serophero'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    "Dance",
                    "Drama",
                    'Music',
                    'Visual Art',
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "2" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science',
                    'Hamro Serophero'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    "Dance",
                    "Drama",
                    'Music',
                    'Visual Art',
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "3" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science',
                    'Hamro Serophero'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    "Dance",
                    "Drama",
                    'Music',
                    'Visual Art',
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "4" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'HPCA'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    "Dance",
                    "Drama",
                    'Music',
                    'Visual Art',
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "5" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'HPCA',
                    'Nepal Bhasa'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "6" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'HPCA',
                    'Nepal Bhasa'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "7" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'HPCA',
                    'Nepal Bhasa'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "8" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'HPCA',
                    'Nepal Bhasa'
                ],
                "CREDIT" => [
                    "Sanskrit",
                    "Coding"
                ],
                "ECA" => [
                    'Club I',
                    'Club II',
                    'English',
                    'Nepali',
                ]
            ],
            "9" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Compulsory Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'Additional Mathematics',
                    'Computer Science'
                ],
                "CREDIT" => [
                    "Coding"
                ],
                "ECA" => [
                    'Club',
                    'English',
                    'Nepali',
                ]
            ],
            "10" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Compulsory Mathematics',
                    'Science and Technology',
                    'Samajik Aadhyan',
                    'Additional Mathematics',
                    'Computer Science'
                ],
                "CREDIT" => [
                    "Coding"
                ],
                "ECA" => [
                    'Club',
                    'English',
                    'Nepali',
                ]
            ],
            "11" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Physics',
                    'Chemistry',
                    'Mathematics',
                    'Biology',
                    'Computer Science'
                ],
                "CREDIT" => [
                    "Python Programming",
                    "Java Programming"
                ],
                "ECA" => [
                    'Club',
                    'English',
                    'Nepali',
                ]
            ],
            "12" => [
                "MAIN" => [
                    'Nepali',
                    'English',
                    'Physics',
                    'Chemistry',
                    'Mathematics',
                    'Biology',
                    'Computer Science'
                ],
                "CREDIT" => [
                    "Python Programming",
                    "Java Programming"
                ],
                "ECA" => [
                    'Club',
                    'English',
                    'Nepali',
                ]
            ],
        ];











        return $subjects[$gradeName][$subjectType];
    }


    private $types = ["MAIN", "CREDIT", "ECA"];



}