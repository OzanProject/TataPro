<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $school_name ?? 'TataPro' }} | Log in</title>

  @if(isset($school_logo) && $school_logo)
    <link rel="icon" href="{{ asset('storage/' . $school_logo) }}" type="image/png">
  @endif

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">

  <style>
    body.login-page {
      background-color: #f3f4f6;
      /* Modern light gray */
      font-family: 'Inter', sans-serif;
      /* Modern font fallback */
    }

    .card-primary.card-outline {
      border-top: 3px solid #1e3a8a;
      /* Deep Navy Blue */
    }

    .btn-primary {
      background-color: #1e3a8a;
      border-color: #1e3a8a;
    }

    .btn-primary:hover {
      background-color: #1e40af;
      border-color: #1e40af;
    }

    .login-logo a {
      color: #111827;
      font-weight: 700;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary shadow-sm" style="border-radius: 10px;">
      <div class="card-header text-center">
        @if(isset($school_logo) && $school_logo)
          <img src="{{ asset('storage/' . $school_logo) }}" alt="Logo" style="height: 50px; margin-bottom: 10px;">
          <br>
        @endif
        <a href="/" class="h3"><b>{{ $school_name ?? 'TataPro' }}</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masuk untuk memulai sesi anda</p>

        <form action="{{ url('/login') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">
                  Ingat Saya
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-1 mt-3">
          <a href="forgot-password.html">Lupa password?</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="text-center mt-3 text-muted">
      <small>&copy; {{ date('Y') }} {{ $school_name ?? 'Sistem Administrasi Tata Usaha Sekolah' }}</small>
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>
</body>

</html>