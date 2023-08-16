<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fruit Market</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('cms/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('cms/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('cms/dist/css/adminlte.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('cms/plugins/toastr/toastr.min.css')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('cms/dist/img/img.png')}}">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('cms/dist/img/img.png')}}" alt="AdminLTELogo" height="60"
             width="60">
        <h2 class="text-success text-center text-bold">Fruit Market</h2>
    </div>

    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="cms/index2.html" class="h1"><b>Fruit Market</b>APP</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" id="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                  <div class="col-8">
                    <div class="icheck-primary">
                      <input type="checkbox" id="remember">
                      <label for="remember">
                        Remember Me
                      </label>
                    </div>
                  </div> --}}
                <!-- /.col -->
                <div class="col-4">
                    <button type="button" onclick="performStore()" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
        </div>
        </form>
        {{-- <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p> --}}
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('cms/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('cms/dist/js/adminlte.min.js')}}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>--}}
<script src="{{asset('js/axios.js')}}"></script>
<script src="{{asset('cms/plugins/toastr/toastr.min.js')}}"></script>

<script>
    function performStore() {
        console.log('Perform Store');
        axios.post('/cms/login', {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
        })
            .then(function (response) {
                console.log(response);
                // toastr.success(response.data.message);
                window.location.href = '/cms/admin/'
            })
            .catch(function (error) {
                console.log(error);
                toastr.error(error.response.data.message);
            });
    }
</script>
</body>

</html>
