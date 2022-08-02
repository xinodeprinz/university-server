@extends('layouts.pdf')
@section('content')
    <h2 class="uppercase center">{{ $type }} Receipt</h2>
    <table class="table">
        <thead>
            <tr>
                <th class="num">#</th>
                <th class="a">Attribute</th>
                <th class="v">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Amount</td>
                <td>{{ $amount }} FCFA</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Payment Method</td>
                <td>{{ $method }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Payment Date</td>
                <td>{{ $date }}</td>
            </tr>
        </tbody>
    </table>
@endsection