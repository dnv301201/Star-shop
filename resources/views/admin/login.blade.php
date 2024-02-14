
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/page/login.css') }}">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b>Star</a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Đăng nhập phiên làm việc</p>

        <form action="{{ route('admin.login.store') }}" method="post">
          <div class="input-group mb-3">
            <input name = "email" class="form-control" placeholder="Email" value="{{ old('email') }}">  
            {{-- type='email' --}}
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          @error('email')
            <span class="error-message">*{{
              $errors -> first('email')  }}</span>
          @enderror
          <div class="input-group mb-3">
            <input type="password" name = "password"class="form-control" placeholder="Mật khẩu" >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          @error('password')
            <span class="error-message">*{{
              $errors -> first('password')  }}</span>
          @enderror
          <div class="row">
            <div class="col-7">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">
                  Nhớ tôi
                </label>
              </div>
            </div>

            <div class="col-5">
              <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </div>

          </div>
          <p class="mb-1">
            <a href="#">Quên mật khẩu</a>
          </p>
          <div class="row">
            <div class="col-4">

            </div>
          </div>
          @csrf
        </form>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="{{ asset('/adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
