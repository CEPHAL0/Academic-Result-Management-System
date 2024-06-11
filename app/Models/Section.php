<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "grade_id",
        "class_teacher_id"
    ];

    public function classTeacher(): BelongsTo
    {
        return $this->belongsTo(User::class, "class_teacher_id");
    }
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, "grade_id");
    }

    public function subjectTeachers(): HasMany
    {
        return $this->hasMany(SubjectTeacher::class, "section_id");
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, "section_id");
    }
}
