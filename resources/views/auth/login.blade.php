<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('dashboardassets/images/favicon.ico') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('dashboardassets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('dashboardassets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css -->
    <link href="{{ asset('dashboardassets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            font-size: 1.25rem;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-link {
            color: #007bff;
            text-decoration: none;
        }

        .btn-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .invalid-feedback {
            font-size: 0.85rem;
        }
    </style>
</head>

<body data-sidebar="dark">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">{{ __('Login') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('dashboardassets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('dashboardassets/js/app.js') }}"></script>
</body>

</html>
