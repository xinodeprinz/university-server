@extends('layouts.pdf')
@section('content')
    <h2 class="uppercase center">CA results for {{ $academic_year }} {{ $semester }}</h2>
    <table class="table">
        <thead>
            <tr>
                <th style="padding-left:30px">#</th>
                <th>course code</th>
                <th style="padding-left:-20px !important">course title</th>
                <th>cv</th>
                <th style="padding-left:30px">mark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $id => $course)
                <tr>
                    <td>{{ ++$id }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_title }}</td>
                    <td>{{ $course->credit_value }}</td>
                    <td>{{ $course->ca_mark }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="uppercase center">Total Credit Value: {{ $total_credit }}</td>
            </tr>
        </tfoot>
    </table>
@endsection