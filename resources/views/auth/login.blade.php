<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | E-Learning</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/logos/seodashlogo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

    <style>
        body {
            background: #eef2fc;
            min-height: 100vh;
        }

        .login-card {
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        .login-left {
            background: #f8f9fc;
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row w-100 justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card login-card">
                    <div class="login-left">

                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/images/logos/logo-light.svg') }}" width="120">
                            <h4 class="mt-3 fw-bold">Login E-Learning</h4>
                            <p class="text-muted">
                                Silakan masuk untuk mengakses layanan akademik yang tersedia.
                            </p>
                        </div>

                        <form action="{{ route('login.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Masukkan email"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                                <a href="#" class="text-primary fw-semibold">Lupa password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-login">
                                Masuk
                            </button>
                        </form>


                        <p class="text-center mt-4 mb-0">
                            Belum memiliki akun?
                            <a href="{{ route('register') }}" class="fw-bold text-primary">
                                Daftar sekarang
                            </a>

                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>