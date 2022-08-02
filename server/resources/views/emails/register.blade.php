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
    Thank you for registering under NdeTek university.
    We are pleased to inform you that you've been successfully
    admitted into our university. Below are your registration
    information:
</p>
<table style="border-collapse:collapse" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Attribute</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Student Name</td>
            <td>{{$name}}</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Date of Birth</td>
        <td>{{$date_of_birth}}</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Faculty</td>
            <td>{{$faculty}}</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Department</td>
            <td>{{$department}}</td>
        </tr>
    </tbody>
</table>
<p>
    You've been issued the matricule <h3>{{ $matricule }}</h3>
    and your initial account password is <h3>{{ $password }}</h3>
    You're advised to change your account password when
    you login.
</p>

@component('mail::button', ['url' => 'http://localhost:3000'])
Download Registration Receipt
@endcomponent
<div style="text-align:center">
    <a href="http://localhost:3000/login" target="_blank">Login into your Accout</a>
</div>

Yours sincerely,<br>
<strong>{{ config('app.name') }}</strong>
@endcomponent
