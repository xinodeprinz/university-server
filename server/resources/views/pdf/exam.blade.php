@extends('layouts.pdf')
@section('content')
    <h2 class="uppercase center">Exam results for {{ $academic_year }} {{ $semester }}</h2>
    <table class="table">
        <thead>
            <tr>
                <th style="margin-left:-10px !important">#</th>
                <th>cc</th>
                <th>course title</th>
                <th>cv</th>
                <th>CA</th>
                <th>Exam</th>
                <th>Total</th>
                <th>grade</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($courses as $id => $course)
            <tr>
                <td style="margin-left:-50px !important">{{ ++$id }}</td>
                <td style="margin-left:-30px !important">{{ $course->course_code }}</td>
                <td>{{ $course->course_title }}</td>
                <td style="margin-left:-30px !important">{{ $course->credit_value }}</td>
                <td style="margin-left:-20px !important">{{ $course->ca_mark }}</td>
                <td style="margin-left:-10px !important">{{ $course->exam_mark }}</td>
                <td>{{ $course->total_mark }}</td>
                <td>{{ $course->grade }}</td>
            </tr>
           @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="uppercase">Total Credit Value: {{ $total_credit }}</td>
                <td colspan="4" class="uppercase" style="margin-left:-50px !important">Credit Earned: {{ $credit_earned }}</td>
                <td colspan="2" class="uppercase" style="padding-left:-40px !important">GPA: {{ $gpa }}</td>
            </tr>
        </tfoot>
    </table>
@endsection