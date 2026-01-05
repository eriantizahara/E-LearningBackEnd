<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | E-Learning</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/logos/seodashlogo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

  <style>
    body {
      background: #eef2fc;
      min-height: 100vh;
    }

    .register-card {
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
    }

    .register-body {
      background: #f8f9fc;
      padding: 40px;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px;
    }

    .btn-register {
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
        <div class="card register-card">
          <div class="register-body">

            <div class="text-center mb-4">
              <img src="{{ asset('assets/images/logos/logo-light.svg') }}" width="120">
              <h4 class="mt-3 fw-bold">Registrasi Akun</h4>
              <p class="text-muted">
                Lengkapi data berikut untuk membuat akun pada sistem E-Learning.
              </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap">
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email">
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password">
              </div>

              <button type="submit" class="btn btn-primary w-100 btn-register">
                Daftar
              </button>

              <p class="text-center mt-4 mb-0">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="fw-bold text-primary">
                  Login
                </a>
              </p>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>