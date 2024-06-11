<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OldTable extends Model
{
    use HasFactory;

    protected $table = "old_table";
    protected $fillable = [
        'roll_no',
        'emis_no',
        'student_name',
        'subject_name',
        'grade_name',
        'term_name',
        'term_marks'
    ];
    public function oldcas(): HasMany
    {
        return $this->hasMany(OldCasMark::class, 'old_table_id');
    }

   
}
