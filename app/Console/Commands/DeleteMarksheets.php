<?php

namespace App\Console\Commands;

use App\Models\Term;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;


class DeleteMarksheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:marksheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Marksheets after 2 days of result';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTerms = Term::whereDate('result_date', Carbon::now()->subDays(2))

            ->where('is_result_generated', 1)

            ->get();

        if ($currentTerms->isEmpty()) {
            Log::info("Searched for the term end dates in three days. Found None.");
        }

        foreach ($currentTerms as $term){
            $this->deleteMarksheetsForTerm($term);

            $term->is_result_generated = 0;
            $term->save();
        }
    }

    private function deleteMarksheetsForTerm(Term $term)
    {
        $directoryPath = storage_path('app/Grade ' . $term->grade->name);
        $zipFilePath = storage_path('app/Grade ' . $term->grade->name . '.zip');

        if (File::exists($directoryPath)) {
            File::deleteDirectory($directoryPath);
        }

        if (File::exists($zipFilePath)) {
            File::delete($zipFilePath);
        }
    }
}
