<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Star | Đăng ký </title>

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
<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      Đăng Ký<a href="{{ route('users.index') }}"><b> Star Shop</b></a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Đăng ký tài khoản mới</p>

        <form action="{{ route('register.store') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" name = "name" class="form-control" placeholder="Họ tên" value="{{ old('name') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          @error('name')
            <span class="error-message">*{{
            $errors -> first('name')  }}</span>
          @enderror
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
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
            <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
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
          <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                Tôi đồng ý với các <a href="#">điều khoản sử dụng.</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-dark btn-block">Đăng ký</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="{{ route('user.login') }}" class="text-center">Đăng nhập với tài khoản đã tồn tại</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="{{ asset('/adminlte/plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('/adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>