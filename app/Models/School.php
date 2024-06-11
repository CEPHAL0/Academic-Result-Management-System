<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'head_of_school_id',
        'theory_weightage',
        'cas_weightage',
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }


    public function headOfSchool(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_of_school_id');
    }

    public function examMarks()
    {
        // Add hasMany
    }

    public function cas()
    {
        // Add hasMany
    }

    public function casTypes(): HasMany
    {
        return $this->hasMany(CasType::class, "school_id");
    }

    public function activities()
    {
        // add hasMany
    }

}
