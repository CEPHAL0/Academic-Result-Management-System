<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldCasMark extends Model
{
    use HasFactory;
    protected $table = "old_cas_marks";

    protected $fillable = [
        'cas_type',
        'cas_marks',
        'assignment_name',
        'subject_name',
        'roll_number',
        'student_name',
        'term_name',
        'grade_name',
        
    ];


}
