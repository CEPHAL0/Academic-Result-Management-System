<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentExam extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "symbol_no"
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function exams():HasMany
    {
        return $this->hasMany(Exam::class,'student_exam_id');
    }
}
