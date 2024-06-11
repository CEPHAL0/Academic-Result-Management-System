<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class GenerateMarksheetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        
        $html = view('admin.marksheets.middleandhighschool')->render();
        $pdf = Browsershot::html($html)
                ->setIncludePath('$PATH:/usr/local/bin')
                ->pdf();

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attacchment; filename = "example.pdf"',
            'Content-Length' => strlen($pdf)
        ]);
    }
}
