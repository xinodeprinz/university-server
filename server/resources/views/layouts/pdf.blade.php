<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NdeTek</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif }
        #head {
            display: flex;
            align-items: center;
            text-transform: uppercase;
            font-weight: bold;
        }
        .ndetek {}
        #logo {
            margin-left: 250px;
            margin-top: 15px;
        }
        .cameroon {
            text-align: right;
        }
        #head h3, hr, #dynamic h2 { color: #007bff }
        .break { margin-top: -160px }
        #student-info { display: flex }
        .right { text-align: right }
        .uppercase { text-transform: uppercase; color: #007bff }
        .y { margin-top: -145px }
        #dynamic h2 { text-transform: uppercase; text-align: center }
        p, li { line-height: 2em; font-size: 20px; text-align: justify }
        .stamp { margin-top: 100px; text-align: right }
        .stamp h4 { margin-top: -20px; font-style: italic }
        .center { text-align: center }

        /* table */
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

        .table-sm th,
        .table-sm td {
        padding: 0.3rem;
        }

        .table-bordered {
        border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
        border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody + tbody {
        border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
        color: #212529;
        background-color: rgba(0, 0, 0, 0.075);
        }
        th { text-transform: uppercase }
        td { padding-left: 50px !important }
        .num { padding-left: -15px !important }
        .a, .v { padding-left: -100px !important }
    </style>
</head>
<body>
    <div id="head">
        <div class="ndetek">
            <h3>NdeTek</h3>
            <h5>The Heart of Technology</h5>
        </div>
        <div>
            <img id="logo" src="{{ storage_path('app/public').'/images/receipt_logo.jpg' }}" alt="" class="img-fluid" width="150">
        </div>
        <div class="cameroon">
            <h3>Republic of Cameroon</h3>
            <h5>Peace-Work-Fatherland</h5>
        </div>
    </div><hr class="break">
    {{-- Students section --}}
    <section id="student-info">
        <div class="left">
            <h4>Name: <strong class="uppercase">{{ $name }}</strong></h4>
            <h4>Date of Birth: <strong class="uppercase">{{ $date_of_birth }}</strong></h4>
            <h4>Matricule: <strong class="uppercase">{{ $matricule }}</strong></h4>
        </div>
        <div class="right">
            <h4><strong class="uppercase">{{ $faculty }}</strong></h4>
            <h4>Department: <strong class="uppercase">{{ $department }}</strong></h4>
            <h4>Academic Year: <strong class="uppercase">{{ $academic_year }}</strong></h4>
        </div>
    </section> <hr class="y">
      
    <main>
        @yield('content')
    </main>
    
    {{-- Stamp section --}}
    <div class="stamp">
        <img width="250" class="img-fluid" src="{{ storage_path('app/public').'/images/signed_stamp.jpg' }}" alt="">
        <h4 class="uppercase">The Registrar</h4>
    </div>
</body>
</html>