<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory;

    protected $fillable = ["name", "start_date", "end_date", "grade_id","result_date", "is_result_generated"];


    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, "grade_id");
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class, "term_id");
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, "term_id");
    }


}
