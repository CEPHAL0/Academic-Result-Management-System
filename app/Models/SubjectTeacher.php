<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SubjectTeacher extends Model
{
    use HasFactory;

    protected $table = "subject_teachers";

    protected $fillable = [
        "subject_id",
        "teacher_id",
        "section_id"
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, "subject_id");
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, "teacher_id");
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, "section_id");
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, "subject_teacher_id");
    }

}
