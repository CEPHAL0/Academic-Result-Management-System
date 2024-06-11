<?php

namespace App\Console\Commands;


use App\Helpers\GenerateMarksheetForGradeElevenToTwelve;
use App\Helpers\GenerateMarksheetForGradeFiveToEight;
use App\Helpers\GenerateMarksheetForGradeFour;
use App\Helpers\GenerateMarksheetForGradeNineAndTen;
use App\Helpers\GenerateMarksheetForGradeOneToThree;
use App\Mail\ResultMail;

use App\Models\Cas;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi;
use App\Helpers\MarkSortAndMerge;


class GenerateMarksheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:marksheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Marksheets of the term based on the calendar event';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // first get all the cas marks of the
        // current term based on the currWent date
        $currentTerms = Term::whereDate('result_date', Carbon::now()->addDays(2))

            ->where('is_result_generated', 0)

            ->get();
        if ($currentTerms->isEmpty()) {
            Log::info("Searched for the term end dates in three days. Found None.");
        }
        foreach ($currentTerms as $currentTerm) {

            $subjects = Subject::where('grade_id', $currentTerm->grade_id)
                ->get();

            $students = Student::with('section.grade')
                ->whereHas('section.grade', function (Builder $query) use ($currentTerm) {
                    $query->where('id', $currentTerm->grade_id);
                })
                ->get();

            foreach ($students as $student) {
                $casGradePointCollectionByStudent = collect([]);
                $casGradeCollectionByStudent = collect([]);
                $examGradePointCollectionByStudent = collect([]);
                $examGradeCollectionByStudent = collect([]);
                foreach ($subjects as $subject) {
                    // cas marks
                    $cumulativeCasMarkBySubject = Cas::calculateTotalMarksPerSubjectTeacher($subject->id, $student->id, $currentTerm->start_date, $currentTerm->end_date);
                    $gradePointBySubjectForCas = Cas::gradePoint($subject, $cumulativeCasMarkBySubject);
                    $gradeConversionForCas = Cas::gradeConversion($subject, $cumulativeCasMarkBySubject);

                    // exam marks
                    $examMarksBySubject = Exam::with(['studentExam.student', 'subjectTeacher.subject'])
                        ->whereHas('studentExam.student', function (Builder $query) use ($student) {
                            $query->where('id', $student->id);
                        })
                        ->whereHas('subjectTeacher.subject', function (Builder $query) use ($subject) {
                            $query->where('id', $subject->id);
                        })
                        ->whereDate('created_at', '>=', $currentTerm->end_date)
                        ->where('created_at', '<=', $currentTerm->result_date)
                        ->first();

                    
                    // if(!$examMarksBySubject){
                    //     // todo: send mail if examMarksBySubject is null
                    // }


                    $gradePointForExamMarks = Exam::gradePoint($subject, $examMarksBySubject->mark ?? 0);
                    $gradeConversionForExamMarks = Exam::gradeConversion($subject, $examMarksBySubject->mark ?? 0);

                    // put into the collection

                    $casGradePointCollectionByStudent->push(['cas_mark' => $gradePointBySubjectForCas, 'type' => $subject->type, 'name' => $subject->name, 'credit_hour'=>$subject->credit_hr]);
                    $casGradeCollectionByStudent->push(['cas_grade' => $gradeConversionForCas, 'type' => $subject->type, 'name' => $subject->name]);

                    $examGradePointCollectionByStudent->push(['exam_mark' => $gradePointForExamMarks, 'type' => $subject->type, 'name' => $subject->name]);
                    $examGradeCollectionByStudent->push(['exam_grade' => $gradeConversionForExamMarks, 'type' => $subject->type, 'name' => $subject->name]);
                }

                // now order the marks according to the order of result
                if ($currentTerm->grade->name >= 1 && $currentTerm->grade->name <= 3) {
                    $sortOrderForMainSubjects = ['Nepali', 'English', 'Mathematics', 'Science', 'Hamro Serophero'];
                    $sortOrderForCreditSubjects = ['Sanskrit', 'Coding'];
                    $sortOrderForEcaSubjects = ['Dance', 'Drama', 'Music', 'Visual Art', 'Club I', 'Club II', 'English', 'Nepali'];

                    $marks = MarkSortAndMerge::sortAndMerge($casGradePointCollectionByStudent, $casGradeCollectionByStudent, $examGradePointCollectionByStudent, $examGradeCollectionByStudent, $sortOrderForMainSubjects, $sortOrderForCreditSubjects, $sortOrderForEcaSubjects);
                    Log::error($marks);
                    GenerateMarksheetForGradeOneToThree::generate($student, $currentTerm, $marks);

                    //now send these marks to pdf generator
                } elseif ($currentTerm->grade->name == 4) {
                    $sortOrderForMainSubjects = ['Nepali', 'English', 'Mathematics', 'Science & Technology', 'Samajik Aadhyan','HPCA'];
                    $sortOrderForCreditSubjects = ['Sanskrit', 'Coding'];
                    $sortOrderForEcaSubjects = ['Dance', 'Drama', 'Music', 'Visual Art', 'Club I', 'Club II', 'English', 'Nepali'];
                    
                    $marks = MarkSortAndMerge::sortAndMerge($casGradePointCollectionByStudent, $casGradeCollectionByStudent, $examGradePointCollectionByStudent, $examGradeCollectionByStudent, $sortOrderForMainSubjects, $sortOrderForCreditSubjects, $sortOrderForEcaSubjects);
                    try {
                        GenerateMarksheetForGradeFour::generate($student,$currentTerm,$marks);
                    }catch (\Exception $e){
                        Log::error('An error occured'. $e->getMessage());
                    }


                    //now send these marks to pdf generator
                } elseif ($currentTerm->grade->name >= 5 && $currentTerm->grade->name <= 8) {
                    $sortOrderForMainSubjects = ['Nepali', 'English', 'Mathematics', 'Science & Technology', 'Samajik Aadhyan','HPCA','Nepal Bhasa'];
                    $sortOrderForCreditSubjects = ['Sanskrit', 'Coding'];
                    $sortOrderForEcaSubjects = ['Club I', 'Club II', 'English', 'Nepali'];

                    $marks = MarkSortAndMerge::sortAndMerge($casGradePointCollectionByStudent, $casGradeCollectionByStudent, $examGradePointCollectionByStudent, $examGradeCollectionByStudent, $sortOrderForMainSubjects, $sortOrderForCreditSubjects, $sortOrderForEcaSubjects);
                    GenerateMarksheetForGradeFiveToEight::generate($student,$currentTerm,$marks);
                    //now send these marks to pdf generator
                }
                elseif ($currentTerm->grade->name >= 9 && $currentTerm->grade->name <= 10) {
                    $sortOrderForMainSubjects = ['Nepali', 'English', 'C. Mathematics', 'Science & Technology', 'Samajik Aadhyan', 'HPCA', 'A Mathematics', 'Computer Science'];
                    $sortOrderForCreditSubjects = ['Coding'];
                    $sortOrderForEcaSubjects = ['Club', 'English', 'Nepali'];
                   
                    $marks = MarkSortAndMerge::sortAndMerge($casGradePointCollectionByStudent, $casGradeCollectionByStudent, $examGradePointCollectionByStudent, $examGradeCollectionByStudent, $sortOrderForMainSubjects, $sortOrderForCreditSubjects, $sortOrderForEcaSubjects);

                    GenerateMarksheetForGradeNineAndTen::generate($student,$currentTerm,$marks);

                    //now send these marks to pdf generator
                }
                else {
                    $sortOrderForMainSubjects = ['Nepali', 'English', 'Physics', 'Chemistry', 'Mathematics', 'Biology', 'Computer Science'];
                    $sortOrderForCreditSubjects = ['Python Programming, Java Programming'];
                    $sortOrderForEcaSubjects = ['Club', 'English', 'Nepali'];
                    //filter
                    $marks = MarkSortAndMerge::sortAndMerge($casGradePointCollectionByStudent, $casGradeCollectionByStudent, $examGradePointCollectionByStudent, $examGradeCollectionByStudent, $sortOrderForMainSubjects, $sortOrderForCreditSubjects, $sortOrderForEcaSubjects);
                    GenerateMarksheetForGradeElevenToTwelve::generate($student,$currentTerm,$marks);
                }
            }
            // set the current term's is_result_generated to 1
            $currentTerm->is_result_generated = 1;
            $currentTerm->save();

        }
    }
}
