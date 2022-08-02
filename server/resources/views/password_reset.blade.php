<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/all.js"></script>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center
        }
        .fa-eye, .fa-eye-slash {
            cursor: pointer;
        }
        .background-image {
        background: url("/images/laptop.jpg") no-repeat 0, 0;
        background-size: cover;
        background-position: center;
        position: relative;
        }
        .background-image .row {
        position: relative;
        z-index: 1;
        }
        .background-image:after {
        position: absolute;
        content: " ";
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        background-color: #007bff;
        opacity: 0.5;
        }
    </style>
</head>
<body class="background-image">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header text-primary text-uppercase font-weight-bold d-flex align-items-center justify-content-between">
                        <div>
                            <img src="/images/ndetek_white.png" width="150" class="img-fluid">
                        </div>
                        <div>Reset Password</div>
                    </div>
                    <?php $route = "/password-reset/$name/$id" ?>
                    <div class="card-body text-white bg-primary">
                        <form method="POST" action="{{ $route }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>New Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i onclick="show(this)" class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password" value="{{ old('newPassword') }}" id="password" name="newPassword" class="form-control" placeholder="New Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i onclick="show(this)" class="fas fa-eye"></i>
                                        </div>
                                    </div>
                                </div>
                                @error('newPassword')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-info btn-block" type="submit">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function show(element)
        {
            const pass = document.getElementById('password');
            if (pass.type === 'password') {
                element.classList.remove('fa-eye');
                element.classList.add('fa-eye-slash');
                pass.type = 'text';
            } else {
                element.classList.add('fa-eye');
                element.classList.remove('fa-eye-slash');
                pass.type = 'password';
            }
        }
    </script>
</body>
</html>