<!doctype html>
<html lang="en">
<head>
    @include('Backend.Login.Sections.head')
</head>
<body class="hold-transition login-page">
    @include('Backend.Login.Sections.header')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="javascript:void(0)" class="h1"><b>Admin Panel</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Daxil ol</p>

                <form action="{{url('/login/loginAction')}}" method="post" id="loginForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Şifrə">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="button" class="btn btn-primary btn-block" id="loginBtn">Daxil ol</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->



</body>
<footer>
    @include('Backend.Login.Sections.footer')
    <script>
        $(document).ready(function()
        {
            $("#loginBtn").on("click", function(){
                $.ajax({
                    type: "post",
                    url: "{{url('login/loginAction')}}",
                    data: $("#loginForm").serialize(),
                    dataType: "json",
                    beforeSend: function()
                    {
                        $(".progress").show();
                    },
                    success: function(e)
                    {
                        Swal.fire({
                            title: '',
                            text: e.success,
                            icon: 'success'
                        });
                    },
                    error: function(x)
                    {
                        var errorResponse = x.responseJSON || x.responseText;
                        Swal.fire({
                            title: '',
                            text: errorResponse.error,
                            icon: 'error'
                        });
                    },
                    complete: function()
                    {
                        $(".progress").hide();
                    }
                });
            });
        });
    </script>
</footer>
</html>
