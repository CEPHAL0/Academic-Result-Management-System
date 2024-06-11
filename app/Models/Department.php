<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "head_of_department_id"
    ];

    public function departmentHead(): BelongsTo
    {
        return $this->belongsTo(User::class, "head_of_department_id");
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
