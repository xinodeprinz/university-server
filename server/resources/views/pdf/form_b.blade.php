@extends('layouts.pdf')
@section('content')
    <h2 class="uppercase center">Registered courses for {{ $academic_year }} {{ $semester }}</h2>
    <table class="table">
        <thead>
            <tr>
                <th style="padding-left:30px">#</th>
                <th>course code</th>
                <th>course title</th>
                <th>credit value</th>
                <th style="padding-left:30px">course master</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $id => $course)
                <tr>
                    <td>{{ ++$id }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_title }}</td>
                    <td>{{ $course->credit_value }}</td>
                    <td>{{ $course->course_master }}</td>
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