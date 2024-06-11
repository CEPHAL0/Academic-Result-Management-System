<?php

namespace App\Http\Controllers\Admin;
header('Content-Type: text/html; charset=utf-8');
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class ResultController extends Controller
{
    public function generatePdf()
    {

        for ($i = 1; $i < 13; $i++) {
            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->setFont('Times', '', '12');

            $path = storage_path("app/images/marksheet/Grade $i.pdf");
            $pdf->setSourceFile($path);
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId, 0, 0, null, null, true);
            $signature = storage_path('app/images/signature.png');

            $rollNumber = "1046";
            $pdf->SetXY(100, 30.3);
            $pdf->Write(0.1, strtoupper($rollNumber));
            $name = "Tushar Luitel";
            $pdf->SetXY(154, 30.3);
            $pdf->Write(0.1, strtoupper($name));
            if ($i >= 11 ) {
                $subjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Second Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($subjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 52 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 52 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 52 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row
                    $pdf->SetXY(79, 58.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_credit_hour']);
                    $pdf->SetXY(110, 58.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 58.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 55.6 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $gradePointAverage = 4.0;
                $pdf->SetXY(62, 149.7);
                $pdf->Write(0.1, $gradePointAverage);

                $gradeAverage = "A*";
                $pdf->SetXY(151.5, 149.7);
                $pdf->Write(0.1, $gradeAverage);

                $creditSubjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Second Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($creditSubjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 181 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 181 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 181 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row
                    $pdf->SetXY(79, 187.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_credit_hour']);
                    $pdf->SetXY(110, 187.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 187.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 184.35 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $pdf->SetFont('ZapfDingbats', '', 10);
                $checkMark = "4";
//        First ECA
                $pdf->setXY(38, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 229);
                $pdf->Write(0.1, $checkMark);

//        Second ECA
                $pdf->setXY(38, 235.7);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 235.7);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 235.7);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 235.7);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 235.7);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 242.2);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 242.2);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 242.2);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 242.2);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 242.2);
                $pdf->Write(0.1, $checkMark);

                $pdf->Image($signature, 18, 247, 20, 20);
                $pdf->Image($signature, 185, 247, 20, 20);
            }
            elseif ($i>=9 && $i<11){
                $subjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Second Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ]
                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($subjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 52 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 52 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 52 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row
                    $pdf->SetXY(79, 58.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_credit_hour']);
                    $pdf->SetXY(110, 58.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 58.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 55.6 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $gradePointAverage = 4.0;
                $pdf->SetXY(62, 149.7);
                $pdf->Write(0.1, $gradePointAverage);

                $gradeAverage = "A*";
                $pdf->SetXY(151.5, 149.7);
                $pdf->Write(0.1, $gradeAverage);

                $creditSubjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],

                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($creditSubjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 181 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 181 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 181 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row
                    $pdf->SetXY(79, 187.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_credit_hour']);
                    $pdf->SetXY(110, 187.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 187.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 184.35 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $pdf->SetFont('ZapfDingbats', '', 10);
                $checkMark = "4";
//        First ECA
                $pdf->setXY(38, 216);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 216);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 216);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 216);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 216);
                $pdf->Write(0.1, $checkMark);

//        Second ECA
                $pdf->setXY(38, 222.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 222.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 222.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 222.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 222.5);
                $pdf->Write(0.1, $checkMark);
//          Third ECA
                $pdf->setXY(38, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 229);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 229);
                $pdf->Write(0.1, $checkMark);

                $pdf->Image($signature, 18, 243, 20, 20);
                $pdf->Image($signature, 185, 243, 20, 20);
            }
            elseif ($i >=5 && $i<9){
                $subjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Second Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ]
                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($subjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 46.8 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 46.8 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 46.8+ $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row
                    $pdf->SetXY(79, 53.5 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_credit_hour']);
                    $pdf->SetXY(110, 53.5 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 53.5+ $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 50.15 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $gradePointAverage = 4.0;
                $pdf->SetXY(62, 145);
                $pdf->Write(0.1, $gradePointAverage);

                $gradeAverage = "A*";
                $pdf->SetXY(151.5, 145);
                $pdf->Write(0.1, $gradeAverage);

                $creditSubjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],

                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($creditSubjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 176 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 176 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 176 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row
                    $pdf->SetXY(79, 182.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_credit_hour']);
                    $pdf->SetXY(110, 182.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 182.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 179.35 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $pdf->SetFont('ZapfDingbats', '', 10);
                $checkMark = "4";
//        First ECA
                $pdf->setXY(38, 223.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 223.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 223.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 223.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 223.5);
                $pdf->Write(0.1, $checkMark);

//        Second ECA
                $pdf->setXY(38, 230);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 230);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 230);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 230);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 230);
                $pdf->Write(0.1, $checkMark);
//          Third ECA
                $pdf->setXY(38, 236.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 236.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 236.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 236.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 236.5);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 243);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 243);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 243);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 243);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 243);
                $pdf->Write(0.1, $checkMark);

                $pdf->Image($signature, 18, 247, 20, 20);
                $pdf->Image($signature, 185, 247, 20, 20);
            }

            elseif ($i == 4){
                $subjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Second Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],

                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($subjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 50 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 48 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 48 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row

                    $pdf->SetXY(110, 54.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 54.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 50 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $gradePointAverage = 4.0;
                $pdf->SetXY(62, 131.5);
                $pdf->Write(0.1, $gradePointAverage);

                $gradeAverage = "A*";
                $pdf->SetXY(151.5, 131.5);
                $pdf->Write(0.1, $gradeAverage);

                $creditSubjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],

                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($creditSubjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 155 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 152.5 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 152.5 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row

                    $pdf->SetXY(110, 159.2 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 159.2 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 155 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.5;
                    $initalAvgYoffset += 12.9;
                }
                $pdf->SetFont('ZapfDingbats', '', 10);
                $checkMark = "4";
//        First ECA
                $pdf->setXY(38, 196.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 196.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 196.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 196.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 196.5);
                $pdf->Write(0.1, $checkMark);

//        Second ECA
                $pdf->setXY(38, 203);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 203);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 203);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 203);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 203);
                $pdf->Write(0.1, $checkMark);
//          Third ECA
                $pdf->setXY(38, 209.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 209.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 209.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 209.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 209.5);
                $pdf->Write(0.1, $checkMark);

//                Fourth ECA
                $pdf->setXY(38, 218);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 218);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 218);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 218);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 218);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 226.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 226.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 226.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 226.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 226.5);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 233);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 233);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 233);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 233);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 233);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 238.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 238.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 238.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 238.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 238.5);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 245);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 245);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 245);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 245);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 245);
                $pdf->Write(0.1, $checkMark);

                $pdf->Image($signature, 18, 247, 20, 20);
                $pdf->Image($signature, 185, 247, 20, 20);
            }
            else{
                $subjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Second Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "Third Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],

                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($subjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 50 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 48 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 48 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row

                    $pdf->SetXY(110, 54.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 54.7 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 50 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13.2;
                    $initalAvgYoffset += 13.2;
                }
                $gradePointAverage = 4.0;
                $pdf->SetXY(62, 118);
                $pdf->Write(0.1, $gradePointAverage);

                $gradeAverage = "A*";
                $pdf->SetXY(151.5, 118);
                $pdf->Write(0.1, $gradeAverage);

                $creditSubjects = [
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],
                    [
                        "name" => "First Subject",
                        "theory_credit_hour" => "2",
                        "theory_grade_marks" => "A+",
                        "theory_grade_point" => "3.65",
                        "practical_credit_hour" => "3",
                        "practical_grade_marks" => "A",
                        "practical_grade_point" => "3.6",
                        "average_total_point" => "3.6",
                    ],

                ];

                $initialYOffset = 0;
                $initalAvgYoffset = 0;

                foreach ($creditSubjects as $subject) {
                    // Calculate Y offset dynamically
                    $y_offset = $initialYOffset;
                    $y_avgoffset = $initalAvgYoffset;

                    $pdf->SetXY(79, 149.15 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['theory_credit_hour']);
                    $pdf->SetXY(110, 145.8 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_marks']);
                    $pdf->SetXY(141, 145.8 + $y_offset);
                    $pdf->Write(0.1, $subject['theory_grade_point']);

                    // Add practical row

                    $pdf->SetXY(110, 152.5 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_marks']);
                    $pdf->SetXY(141, 152.5 + $y_offset);
                    $pdf->Write(0.1, $subject['practical_grade_point']);

                    // Add average row
                    $pdf->SetXY(178, 149.15 + $y_avgoffset);
                    $pdf->Write(0.1, $subject['average_total_point']);


                    $initialYOffset += 13;
                    $initalAvgYoffset += 13.2;
                }
                $pdf->SetFont('ZapfDingbats', '', 10);
                $checkMark = "4";
//        First ECA
                $pdf->setXY(38, 193);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 193);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 193);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 193);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 193);
                $pdf->Write(0.1, $checkMark);

//        Second ECA
                $pdf->setXY(38, 199.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 199.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 199.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 199.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 199.5);
                $pdf->Write(0.1, $checkMark);
//          Third ECA
                $pdf->setXY(38, 206);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 206);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 206);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 206);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 206);
                $pdf->Write(0.1, $checkMark);

//                Fourth ECA
                $pdf->setXY(38, 214.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 214.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 214.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 214.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 214.5);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 223);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 223);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 223);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 223);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 223);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 229.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 229.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 229.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 229.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 229.5);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 236);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 236);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 236);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 236);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 236);
                $pdf->Write(0.1, $checkMark);

                $pdf->setXY(38, 242.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(70, 242.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(110, 242.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(145, 242.5);
                $pdf->Write(0.1, $checkMark);
                $pdf->setXY(180, 242.5);
                $pdf->Write(0.1, $checkMark);

                $pdf->Image($signature, 18, 247, 20, 20);
                $pdf->Image($signature, 185, 247, 20, 20);
            }


            $pdf->Output("F", "Grade $i.pdf");
        }
    }
}
