
<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.header')
  <link rel="stylesheet" href="/backend/scss/style.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b>Star</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Đăng nhập phiên làm việc</p>

        <form action="/admin/users/login/store" method="post">
          <div class="input-group mb-3">
            <input name = "email"class="form-control" placeholder="Email" >  
            {{-- type='email' --}}
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          @if ($errors->has('email'))
          <span class = "error-message">*{{
          $errors -> first('email')  }}</span>
          @endif
          <div class="input-group mb-3">
            <input type="password" name = "password"class="form-control" placeholder="Mật khẩu" >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          @if ($errors->has('password'))
          <span class = "error-message">*{{
          $errors -> first('password')  }}</span>
          @endif
          <div class="row">
            <div class="col-7">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">
                  Nhớ tôi
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-5">
              <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </div>
            <!-- /.col -->
          </div>
          @csrf
        </form>
        <!-- /.social-auth-links -->
        <p class="mb-1">
          <a href="forgot-password.html">Quên mật khẩu</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
<!-- /.login-box -->

  @include('admin.footer')
</body>
</html>
