<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'student_id',
        'term_id',
        'subject_teacher_id',
        'school_id',
        'theory_marks',
        'date_of_exam'
    ];
}
