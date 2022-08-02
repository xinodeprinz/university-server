<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Receipt</title>
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
        .y { margin-top: -210px }
        #dynamic h2 { text-transform: uppercase; text-align: center }
        p, li { line-height: 2em; font-size: 20px; text-align: justify }
        .stamp { margin-top: 100px; text-align: right }
        .stamp h4 { margin-top: -20px; font-style: italic }
        .text-nde { color: #007bff }
        .capitalize { text-transform: capitalize }
        .profile-pic { height: 200px; width: 300px; max-height: 200px; max-width: 300px }
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
            <h4>Place of Birth: <strong class="uppercase">{{ $place_of_birth }}</strong></h4>
            <h4>Gender: <strong class="uppercase">{{ $gender }}</strong></h4>
            <h4>Registered on: <strong class="uppercase">{{ $admitted_on }}</strong></h4>
        </div>
        <div class="right">
            <img class="img-fluid profile-pic" src="{{ storage_path('app/public'). '/'. $image }}" alt="">
        </div>
    </section> <hr class="y">

    {{-- Dynamic section --}}
    <div id="dynamic">
        <h2>Registration Receipt</h2>
        <h4>Dear Mr/Mrs/Miss <strong class="uppercase">{{ $name }}</strong></h4>
        <p>
            Thank you for registering under NdeTek university. You have been registered
            under the <span class="text-nde capitalize">{{ $faculty }}</span> under the department of 
            <span class="text-nde capitalize">{{ $department }}</span>. Be patient
            while we process your files and information. We will get back to you shortly.
        </p>
    </div>
    
    {{-- Stamp section --}}
    <div class="stamp">
        <img width="250" class="img-fluid" src="{{ storage_path('app/public').'/images/signed_stamp.jpg' }}" alt="">
        <h4 class="uppercase">The Registrar</h4>
    </div>
</body>
</html>