<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        "signature",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, "role_users");
    }

    // Check the id foreign key in the school table for head_of_school_id in schools table
    public function schools(): HasMany
    {
        return $this->hasMany(School::class, "head_of_school_id");
    }

    // Check the foreign key in the school table for head_of_department_id in departments table
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, "head_of_department_id");
    }

    // Check the foreign key in the subject_teacher table for teacher_id in grade_subject_teacher table
    public function subjectTeachers(): HasMany
    {
        return $this->hasMany(SubjectTeacher::class, "teacher_id");
    }

    public function hasRole(string $role)
    {
        if ($this->roles->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
}
