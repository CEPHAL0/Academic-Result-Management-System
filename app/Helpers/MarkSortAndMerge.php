<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Arr;
// merges the marks of subject based on provided collection
class MarkSortAndMerge
{
    public static $casGradeCollectionByStudent;

    public static $casGradePointCollectionByStudent;

    public static $examGradeCollectionByStudent;

    public static $examGradePointCollectionByStudent;

    public static $sortOrderForMainSubjects;

    public static $sortOrderForCreditSubjects;

    public static $sortOrderForEcaSubjects;

    private static $subjectTypes = ["MAIN", "CREDIT", "ECA"];

    public static function sortAndMerge(
        $casGradePointCollectionByStudent,
        $casGradeCollectionByStudent,
        $examGradePointCollectionByStudent,
        $examGradeCollectionByStudent,
        $sortOrderForMainSubjects,
        $sortOrderForCreditSubjects,
        $sortOrderForEcaSubjects
    ) {
        // set the static variables
        self::$casGradeCollectionByStudent = $casGradeCollectionByStudent;
        self::$casGradePointCollectionByStudent = $casGradePointCollectionByStudent;
        self::$examGradeCollectionByStudent = $examGradeCollectionByStudent;
        self::$examGradePointCollectionByStudent = $examGradePointCollectionByStudent;
        self::$sortOrderForMainSubjects = $sortOrderForMainSubjects;
        self::$sortOrderForCreditSubjects = $sortOrderForCreditSubjects;
        self::$sortOrderForEcaSubjects = $sortOrderForEcaSubjects;
        // create a new instance of the class

        $marks = array();

        $instance = new self();

        try {
            foreach (self::$subjectTypes as $subjectType) {
                $marks[$subjectType] = ($instance->sort(self::$casGradeCollectionByStudent, $sortOrderForMainSubjects, $subjectType))
                    ->merge(($instance->sort(self::$casGradePointCollectionByStudent, $sortOrderForMainSubjects, $subjectType)))
                    ->merge(($instance->sort(self::$examGradeCollectionByStudent, $sortOrderForMainSubjects, $subjectType)))
                    ->merge(($instance->sort(self::$examGradePointCollectionByStudent, $sortOrderForMainSubjects, $subjectType)))
                    ->groupBy('name')
                    ->map(function ($items) {
                        return Arr::collapse($items);
                    });
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $marks;
    }

    private function sort($collection, $sortOrder, $subjectType)
    {
        return $collection->filter(function ($item) use ($subjectType) {
            return $item['type'] == $subjectType;
        })
            ->sortBy(function ($item) use ($sortOrder) {
                return array_search($item["name"], $sortOrder);
            });
    }
}
