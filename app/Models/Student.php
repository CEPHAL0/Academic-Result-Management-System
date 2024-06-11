<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "roll_number",
        "date_of_birth",
        "father_name",
        "father_contact",
        "mother_name",
        "mother_contact",
        "guardian_name",
        "guardian_contact",
        "email",
        "status",
        "fathers_profession",
        "mothers_profession",
        "guardians_profession",
        "emis_no",
        "reg_no",
        "section_id",
        "image"
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, "section_id");
    }

    public function cas(): HasMany
    {
        return $this->hasMany(Cas::class, "student_id");
    }
    public function studentExams(): HasMany
    {
        return $this->hasMany(StudentExam::class,"student_id");
    }
    


}
