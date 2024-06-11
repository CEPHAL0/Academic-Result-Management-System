<?php

namespace App\Helpers;

use App\Mail\ResultMail;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Support\Facades\Mail;
use setasign\Fpdi\Fpdi;
use ZipArchive;

class GenerateMarksheetForGradeOneToThree
{

    public static function generate(Student $student, Term $term, $marks)
    {

        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setFont('Times', '', '12');

        $path = storage_path("app/images/marksheet/Grade ".$term->grade->name.".pdf");

        $pdf->setSourceFile($path);
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 0, 0, null, null, true);
        $classTeacherSignature = public_path("storage/signatures/".$student->section->classTeacher->signature);
        $principalSignature = public_path("storage/signatures/".$term->grade->school->headOfSchool->signature);

        $pdf->setFont('Times', 'B', '12');
        if (strtoupper($term->name) == "FIRST"){
            $pdf->SetXY(67, 20.6);
            $pdf->Write(0.1, strtoupper($term->name));
        }elseif(strtoupper($term->name) == "SECOND") {
            $pdf->SetXY(61, 20.6);
            $pdf->Write(0.1, strtoupper($term->name));
        }elseif(strtoupper($term->name) == "THIRD") {
            $pdf->SetXY(66, 20.6);
            $pdf->Write(0.1, strtoupper($term->name));
        }else{
            $pdf->SetXY(61, 20.6);
            $pdf->Write(0.1, strtoupper($term->name));
        }
        $year = 2081;
        $pdf->SetXY(141.5, 20.7);
        $pdf->Write(0.1, strtoupper($year));

        $pdf->setFont('Times', '', '12');
        $pdf->SetXY(100, 30.3);
        $pdf->Write(0.1, strtoupper($student->rollNumber));
        $pdf->SetXY(154, 30.3);
        $pdf->Write(0.1, strtoupper($student->name));

        $initialYOffset = 0;
        $initalAvgYoffset = 0;

        $gradePointSum = 0;
        $mainSubjectCount = count($marks["MAIN"]);

        foreach ($marks["MAIN"] as $subject) {
            // Calculate Y offset dynamically
            $y_offset = $initialYOffset;
            $y_avgoffset = $initalAvgYoffset;

            $pdf->SetXY(79, 50 + $y_avgoffset);
            $pdf->Write(0.1, $subject['credit_hour']);
            $pdf->SetXY(110, 48 + $y_offset);
            $pdf->Write(0.1, $subject['exam_grade']);
            $pdf->SetXY(141, 48 + $y_offset);
            $pdf->Write(0.1, $subject['exam_mark']);

            // Add practical row

            $pdf->SetXY(110, 54.7 + $y_offset);
            $pdf->Write(0.1, $subject['cas_grade']);
            $pdf->SetXY(141, 54.7 + $y_offset);
            $pdf->Write(0.1, $subject['cas_mark']);

            // Add average row
            $pdf->SetXY(178, 50 + $y_avgoffset);
            $pdf->Write(0.1, ((float)$subject['cas_mark'] + (float)$subject['exam_mark'])/2);
            $gradePointSum += ((float)$subject['cas_mark'] + (float)$subject['exam_mark']) / 2;

            $initialYOffset += 13.2;
            $initalAvgYoffset += 13.2;
        }
        $gradePointAverage = $mainSubjectCount > 0 ? $gradePointSum / $mainSubjectCount : 0;

        $gradeBoundaries = [
            4 => "A+",
            3.6 => "A",
            3.2 => "B+",
            2.8 => "B",
            2.4 => "C+",
            2 => "C",
            1.6 => "D",
            1=>"NG"
        ];

        $gradeAverage = 'NG';

        foreach ($gradeBoundaries as $boundary => $grade) {
            if ($gradePointAverage >= $boundary) {
                $gradeAverage = $grade;
                break;
            }
        }
        $pdf->SetXY(62, 118);
        $pdf->Write(0.1, $gradePointAverage);


        $pdf->SetXY(151.5, 118);
        $pdf->Write(0.1, $gradeAverage);

        $initialYOffset = 0;
        $initalAvgYoffset = 0;

        foreach ($marks["CREDIT"] as $subject) {
            // Calculate Y offset dynamically
            $y_offset = $initialYOffset;
            $y_avgoffset = $initalAvgYoffset;

            $pdf->SetXY(79, 149.15 + $y_avgoffset);
            $pdf->Write(0.1, $subject['credit_hour']);
            $pdf->SetXY(110, 145.8 + $y_offset);
            $pdf->Write(0.1, $subject['exam_grade']);
            $pdf->SetXY(141, 145.8 + $y_offset);
            $pdf->Write(0.1, $subject['exam_mark']);

            // Add practical row

            $pdf->SetXY(110, 152.5 + $y_offset);
            $pdf->Write(0.1, $subject['cas_grade']);
            $pdf->SetXY(141, 152.5 + $y_offset);
            $pdf->Write(0.1, $subject['cas_mark']);

            // Add average row
            $pdf->SetXY(178, 149.15 + $y_avgoffset);
            $pdf->Write(0.1, ((float)$subject['cas_mark'] + (float)$subject['exam_mark'])/2);;


            $initialYOffset += 13;
            $initalAvgYoffset += 13.2;
        }

        $pdf->SetFont('ZapfDingbats', '', 10);


        $x_positions = [38, 70, 110, 145, 180];
        $y_positions = [193, 199.5, 206, 214.5, 223, 229.5, 236, 242.5];
        $checkMark = "4";

        $i = 0;
        foreach ($marks["ECA"] as $subject) {
            $cas_mark = $subject["cas_mark"];
            $index = array_search($cas_mark, ['Exceptional', 'More Than Satisfactory', 'Satisfactory', 'Need Improvement', 'Not Acceptable']);

            $pdf->setXY($x_positions[$index], $y_positions[$i]);
            $pdf->Write(0.1, $checkMark);


            $i++;
        }

        $pdf->Image($classTeacherSignature, 18, 247, 20, 20);
        $pdf->Image($principalSignature, 185, 247, 20, 20);

        /*
         *$outputFolder = storage_path("app/"$term->grade->name"/");
            if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 0755, true);
            }
         * */

        $outputFolder = storage_path("app/Grade ".$term->grade->name."/");
        if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 0755, true);
        }

        $outputFilePath = $outputFolder . "Grade " . $term->grade->name . " " . $student->name . ".pdf";
        $pdf->Output("F", $outputFilePath);

        $zip_file = storage_path("app/Grade ".$term->grade->name.".zip");
        touch($zip_file);
        $zip = new ZipArchive;

        $this_zip = $zip->open($zip_file);

        if ($this_zip) {
            $file_path = $outputFolder . "Grade " . $term->grade->name . " " . $student->name . ".pdf";
            $name = "Grade " . $term->grade->name . " " . $student->name . ".pdf";
            $zip->addFile($file_path, $name);

        }


    }

}