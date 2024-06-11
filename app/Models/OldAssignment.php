<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OldAssignment extends Model
{
    use HasFactory;

    protected $table = "old_assignments";
    protected $fillable = [
        'assignment_name',
        'assignment_fullmarks',
       
    ];
   
}
