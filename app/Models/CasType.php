<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CasType extends Model
{
    use HasFactory;


    protected $table = "cas_types";
    protected $fillable = ["name", "school_id", "full_marks", "weightage"];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, "school_id");
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, "cas_type_id");
    }
}
