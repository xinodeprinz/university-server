@component('mail::message')
<style>
.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}
</style>
<h1 style="text-align:center;">THE NDETEK UNIVERSITY APP</h1>
<p>
    To reset your password, click on the link below
</p>

<div style="text-align:center">
    <a href="{{ $link }}" target="_blank">{{ $link }}</a>
</div>

Yours sincerely,<br>
<strong>{{ config('app.name') }}</strong>
@endcomponent
