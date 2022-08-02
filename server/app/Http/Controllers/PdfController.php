<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function registrationReceipt($matricule)
    {
        $student = User::where('matricule', $matricule)->first();
        $data = [
            'name' => $student->name,
            'date_of_birth' => date('jS\ F Y', strtotime($student->date_of_birth)),
            'place_of_birth' => $student->place_of_birth,
            'gender' => $student->gender,
            'image' => $student->image_url,
            'phone_number' => $student->phone_number,
            'sub_division' => $student->sub_division,
            'region' => $student->region,
            'faculty' => strtolower($student->faculty),
            'department' => strtolower($student->department),
            'admitted_on' => date('jS\ F Y', strtotime($student->registered_date))

        ];
        $file_name = $student->name.' registration receipt.pdf';
        $pdf = PDF::loadView('pdf.registration', $data);
        return $pdf->download($file_name);
        // return $pdf->stream();
    }

    public function download(Request $request)
    {
        $name = $request->path;
        return Storage::download("public/$name");
    }

    public function admission_letter($matricule)
    {
        $student = User::where('matricule', $matricule)->first();
        $data = [
            'name' => $student->name,
            'date_of_birth' => date('jS\ F Y', strtotime($student->date_of_birth)),
            'matricule' => $student->matricule,
            'faculty' => $student->faculty,
            'department' => $student->department,
            'admitted_on' => date('jS\ F Y, h:i:s A', strtotime($student->registered_date))

        ];
        $matricule = $student->matricule;
        $file_name = "$matricule Admission Letter.pdf";
        $pdf = PDF::loadView('pdf.admission', $data);
        return $pdf->download($file_name);
        // return $pdf->stream();
    }

    public function transaction($matricule)
    {
        $type = request()->query('type');
        $academic_year = request()->query('academic_year');
        $student = User::where('matricule', $matricule)->first();
        $transaction = $student->transactions()
            ->where('type', $type)
            ->where('academic_year', $academic_year)
            ->first();
        $data = [
            'name' => $student->name,
            'date_of_birth' => date('jS\ F Y', strtotime($student->date_of_birth)),
            'matricule' => $matricule,
            'faculty' => $student->faculty,
            'department' => $student->department,
            'academic_year' => $academic_year,
            'type' => $transaction->type,
            'amount' => $transaction->amount,
            'method' => $transaction->method,
            'date' => date('jS\ F Y', strtotime($transaction->created_at)),
        ];
        $file_name = "$matricule $type for $academic_year.pdf";
        $pdf = PDF::loadView('pdf.transaction', $data);
        return $pdf->download($file_name);
        // return $pdf->stream();
    }

    public function form_b($matricule)
    {
        $academic_year = request()->query('academic_year');
        $semester = request()->query('semester');
        $student = User::where('matricule', $matricule)->first();
        $courses = DB::connection('reg_courses')->table($matricule)
            ->where('academic_year', $academic_year)
            ->where('semester', $semester)
            ->get();

            $real_semester = '';
            if ($semester == 1) {
                $real_semester = 'first semester';
            } else if ($semester == 2) {
                $real_semester = 'second semester';
            } else if ($semester == 3) {
                $real_semester = 'first semester resit';
            } else if ($semester == 4) {
                $real_semester = 'second semester resit';
            }
        $totalCredit = 0;
        foreach ($courses as $c) {
            $totalCredit += $c->credit_value;
        }
        $data = [
            'name' => $student->name,
            'date_of_birth' => date('jS\ F Y', strtotime($student->date_of_birth)),
            'matricule' => $student->matricule,
            'faculty' => $student->faculty,
            'department' => $student->department,
            'academic_year' => $academic_year,
            'semester' => $real_semester,
            'courses' => $courses,
            'total_credit' => $totalCredit
        ];
        $file_name = "$matricule form b for $academic_year $real_semester.pdf";
        $pdf = PDF::loadView('pdf.form_b', $data);
        return $pdf->download($file_name);
        // return $pdf->stream();
    }

    public function ca($matricule)
    {
        $academic_year = request()->query('academic_year');
        $semester = request()->query('semester');
        $student = User::where('matricule', $matricule)->first();
        $courses = DB::connection('reg_courses')->table($matricule)
            ->where('academic_year', $academic_year)
            ->where('semester', $semester)
            ->where('ca_mark', '!=', null)
            ->get();

            $real_semester = '';
            if ($semester == 1) {
                $real_semester = 'first semester';
            } else if ($semester == 2) {
                $real_semester = 'second semester';
            } else if ($semester == 3) {
                $real_semester = 'first semester resit';
            } else if ($semester == 4) {
                $real_semester = 'second semester resit';
            }
        $totalCredit = 0;
        foreach ($courses as $c) {
            $totalCredit += $c->credit_value;
        }
        $data = [
            'name' => $student->name,
            'date_of_birth' => date('jS\ F Y', strtotime($student->date_of_birth)),
            'matricule' => $student->matricule,
            'faculty' => $student->faculty,
            'department' => $student->department,
            'academic_year' => $academic_year,
            'semester' => $real_semester,
            'courses' => $courses,
            'total_credit' => $totalCredit
        ];
        $file_name = "$matricule CA results for $academic_year $real_semester.pdf";
        $pdf = PDF::loadView('pdf.ca', $data);
        return $pdf->download($file_name);
        // return $pdf->stream();
    }

    public function exam($matricule)
    {
        $academic_year = request()->query('academic_year');
        $semester = request()->query('semester');
        $student = User::where('matricule', $matricule)->first();
        $courses = DB::connection('reg_courses')->table($matricule)
            ->where('academic_year', $academic_year)
            ->where('semester', $semester)
            ->where('exam_mark', '!=', null)
            ->get();

            $real_semester = '';
            if ($semester == 1) {
                $real_semester = 'first semester';
            } else if ($semester == 2) {
                $real_semester = 'second semester';
            } else if ($semester == 3) {
                $real_semester = 'first semester resit';
            } else if ($semester == 4) {
                $real_semester = 'second semester resit';
            }
        $totalCredit = 0;
        // foreach ($courses as $c) {
        //     $totalCredit += $c->credit_value;
        //     $c->ca_mark = $c->ca_mark ? $c->ca_mark : 0;
        //     $c->total_mark = $c->ca_mark + $c->exam_mark;
        // }

        $totalCredit = $credit_earned = $totalGP_and_CV = $subjects_passed = 0;
        for ($i = 0; $i < count($courses); $i++) {
            $courses[$i]->ca_mark = $courses[$i]->ca_mark == null ? 0 : $courses[$i]->ca_mark;
            $courses[$i]->exam_mark = $courses[$i]->exam_mark == null ? 0 : $courses[$i]->exam_mark;
            $total_mark = $courses[$i]->ca_mark + $courses[$i]->exam_mark;
            $courses[$i]->total_mark = $total_mark;
            $courses[$i]->grade = $this::grade($total_mark)[0];
            $totalGP_and_CV += ($this::grade($total_mark)[1] * $courses[$i]->credit_value);
            $totalCredit += $courses[$i]->credit_value;
            $credit_earned += ($this::grade($total_mark)[1] > 1.5) ? $courses[$i]->credit_value : 0;
            $subjects_passed += ($this::grade($total_mark)[1] > 1.5) ? 1 : 0;
        }
        $gpa = $totalCredit > 0 ? number_format($totalGP_and_CV / $totalCredit, 2) : null;

        $data = [
            'name' => $student->name,
            'date_of_birth' => date('jS\ F Y', strtotime($student->date_of_birth)),
            'matricule' => $student->matricule,
            'faculty' => $student->faculty,
            'department' => $student->department,
            'academic_year' => $academic_year,
            'semester' => $real_semester,
            'courses' => $courses,
            'total_credit' => $totalCredit,
            'gpa' => $gpa,
            'credit_earned' => $credit_earned
        ];
        $file_name = "$matricule Exam results for $academic_year $real_semester.pdf";
        $pdf = PDF::loadView('pdf.exam', $data);
        return $pdf->download($file_name);
        // return $pdf->stream();
    }


    private static function grade($mark)
    {
        if ($mark < 45) {
            return ['F', 0];
        } else if ($mark < 45) {
            return ['D', 1];
        } else if ($mark < 50) {
            return ['D+', 1.5];
        } else if ($mark < 55) {
            return ['C', 2];
        } else if ($mark < 60) {
            return ['C+', 2.5];
        } else if ($mark < 70) {
            return ['B', 3];
        } else if ($mark < 80) {
            return ['B+', 3.5];
        } else {
            return ['A', 4];
        }
    }
}

