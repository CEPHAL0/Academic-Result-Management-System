<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    public $incrementing = true;

    protected $fillable = ["name", "school_id"];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'grade_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, "school_id");
    }

    public function terms(): HasMany
    {
        return $this->hasMany(Term::class, "grade_id");
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, "grade_id");
    }

}