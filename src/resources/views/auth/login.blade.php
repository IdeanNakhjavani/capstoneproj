<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Interior Energy & Air</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/signin.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #FFFFFF;
        }
    </style>
</head>

<body>
    <main class="form-signin">
        <div class="container">
            <div class="row justify-content-center">
                <img alt="Interior Energy & Air" width="250" height="auto"
                    src="https://interiorenergyandair.ca/wp-content/uploads/2021/09/IEA-logo.bmp">

                <form method="POST" action="{{ route('login') }}">

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email
                            Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="checkbox">
                                <label>
                                    <a href="{{ route('forget.password.get') }}">Reset Password</a>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="login">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
