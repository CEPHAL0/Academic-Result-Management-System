<?php

namespace App\Rules;

use Illuminate\Validation\Rule;
use App\Models\Grade;

class ClassNameOrder implements Rule
{
    protected $startClassName;

    public function __construct($startClassName)
    {
        $this->startClassName = $startClassName;
    }

    public function passes($attribute, $value)
    {
        // Fetch the class names based on their IDs
        $startClass = Grade::find($this->startClassName);
        $endClass = Grade::find($value);

        // Compare the class names
        return $startClass && $endClass && $startClass->name < $endClass->name;
    }

    public function message()
    {
        return 'The start class name must be less than the end class name.';
    }
}
