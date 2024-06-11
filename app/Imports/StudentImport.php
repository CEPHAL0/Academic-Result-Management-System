<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToCollection, WithHeadingRow, SkipsOnError, SkipsOnFailure, SkipsEmptyRows
{
    use Importable,SkipsErrors, SkipsFailures;
    /**
    * @param array $rows
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            $section = Section::where('name',$row['section'])->first();
            unset($row['section']);
            if ($section != null) {
                $row['section_id'] = $section->id;
            }
            Validator::make($row->toArray(), [
                "name" => ["required"],
                "roll_number" => ['required'],
                "section_id" => ["required", "exists:sections,id"],
                "date_of_birth" => ["required", "date_format:d/m/Y"],
                "father_name" => ["required"],
                "father_contact" => ["required"],
                "mother_name" => ["required"],
                "mother_contact" => ["required"],
                "guardian_name" => ["required"],
                "guardian_contact" => ["required"],
                "email" => ["required", "email"],
                "emis_no" => ["required"],
                "reg_no" => ["string", "nullable"],
                "fathers_profession" => ["string"],
                "mothers_profession" => ["string"],
                "guardians_profession" => ["string"],
                "image_name" => ["string"]
            ])->validate();
            $dateOfBirth = Carbon::createFromFormat('d/m/Y', $row['date_of_birth'])->format('Y-m-d');
            Student::updateorCreate(
                ['roll_number' => $row['roll_number']],
                [
                'name' => $row['name'],
                'email' => $row['email'],
                'section_id' => $row['section_id'],
                'date_of_birth' =>$dateOfBirth,
                'father_name' => $row['father_name'],
                'father_contact' => $row['father_contact'],
                'mother_name' => $row['mother_name'],
                'mother_contact' => $row['mother_contact'],
                'guardian_name' => $row['guardian_name'],
                'guardian_contact' => $row['guardian_contact'],
                'emis_no' => $row['emis_no'],
                'reg_no' => $row['reg_no'],
                'fathers_profession' => $row['fathers_profession'],
                'mothers_profession' => $row['mothers_profession'],
                'guardians_profession' => $row['guardians_profession'],
                'status' => 'ACTIVE',
                'image' => $row['image_name']
            ]);
        }
    }
}
