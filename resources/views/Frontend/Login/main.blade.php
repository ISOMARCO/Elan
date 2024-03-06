<!DOCTYPE html>
<html lang="en">
<head>
    @include('Frontend.Login.Sections.head')
    <link rel="stylesheet" href="{{asset('Assets/Frontend/sweetalert2/sweetalert2.css')}}">
</head>
<body>
@include('Frontend.Login.Sections.header')
<section class="user-form-part">
    <div class="user-form-banner">
        <div class="user-form-content"><a href="#"><img src="{{asset('Assets/Frontend/images/logo.png')}}" alt="logo"></a>
            <h1>Advertise your assets <span>Buy what are you needs.</span></h1>
            <p>Biggest Online Advertising Marketplace in the World.</p></div>
    </div>
    <div class="user-form-category">
        <div class="user-form-header">
            <a href="#"><img src="{{asset('Assets/Frontend/images/logo.png')}}" alt="logo"></a><a href="{{url('/home')}}"><i class="fas fa-arrow-left"></i></a>
        </div>
        <div class="user-form-category-btn">
            <ul class="nav nav-tabs">
                <li><a href="#login-tab" class="nav-link active" id="login_li" data-toggle="tab">Sign in</a></li>
                <li><a href="#register-tab" class="nav-link" id="register_li" data-toggle="tab">Sign up</a></li>
            </ul>
        </div>
        <div class="tab-pane active" id="login-tab">
            <div class="user-form-title">
                <h2>Welcome!</h2>
            </div>
            <i class="fas fa-spinner fa-spin fa-lg" id="login_spinner" style="--fa-primary-color: #4b0aff; --fa-secondary-color: #4b0aff; display: none"></i>
            <form method="post" id="login_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="email_or_phone" class="form-control" placeholder="Email or Phone">
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="pass" placeholder="Password">
                            <button type="button" class="form-icon"><i class="eye fas fa-eye"></i></button>
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="signin-check" name="remember_me">
                                <label class="custom-control-label" for="signin-check">Remember me</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group text-right"><a href="#" class="form-forgot">Forgot password?</a></div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-inline" id="login_btn"><i class="fas fa-unlock"></i><span>Enter your account</span></button>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
        <div class="tab-pane" id="register-tab">
            <div class="user-form-title"><h2>Register</h2>
                <p>Setup a new account in a minute.</p></div>
            <ul class="user-form-option">
                <li><a href="#"><i class="fab fa-facebook-f"></i><span>facebook</span></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i><span>twitter</span></a></li>
                <li><a href="#"><i class="fab fa-google"></i><span>google</span></a></li>
            </ul>
            <div class="user-form-devider"><p>or</p></div>
            <form method="post" id="register_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Name" name="name" required="required">
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Surname" name="surname">
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Phone number" name="phone_number">
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email" name="email">
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <select class="form-control" name="gender">
                                <option value="MALE" selected>Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <button class="form-icon"><i class="eye fas fa-eye"></i></button>
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Repeat Password" name="repeat_password">
                            <button class="form-icon"><i class="eye fas fa-eye"></i></button>
                            <small class="form-alert" style="display: none"></small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="signup-check" name="agree" required="required">
                                <label class="custom-control-label" for="signup-check">I agree to the all <a href="#">terms & consitions</a>of bebostha.</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button type="button" class="btn btn-inline" id="register_btn">
                                <i class="fas fa-user-check"></i><span>Create new account</span>
                            </button>
                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
</section>
</body>
<footer>
    @include('Frontend.Login.Sections.footer')
    <script src="{{asset('Assets/Frontend/sweetalert2/sweetalert2.js')}}"></script>
    <script>
        $(document).ready(function(){
            if(window.location.hash == '#register-tab' || "{{ request()->routeIs('Register') }}" == true)
            {
                $("#login-tab, #login_li").removeClass("active");
                $("#register-tab, #register_li").addClass("active");
            }
            $("#register_li").on("click", function() {
                window.location.hash = 'register-tab';
            });
            $("#login_li").on("click", function() {
                history.replaceState({}, document.title, window.location.pathname + window.location.search);
            });
            $("#login_btn").on("click", function() {
                $.ajax({
                    type: "post",
                    url: "{{route('Frontend.LoginAction')}}",
                    data: $("#login_form").serialize(),
                    dataType: "json",
                    beforeSend: function() {
                      $("#login_spinner").show();
                    },
                    success: function(e)
                    {
                        $("small").hide();
                        Swal.fire({
                            html: e.success,
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{url('/')}}";
                            }
                        });
                        setTimeout(function(){window.location.href="{{url('/')}}";},2500);
                    },
                    error: function(x)
                    {
                        var errorResponse = x.responseJSON || x.responseText;
                        $("small").hide();
                        $.each(errorResponse.error, function (index, value)
                        {
                            if(index == 'show_alert')
                            {
                                Swal.fire({
                                    title: "",
                                    text: value,
                                    icon: 'error'
                                });
                            }
                            else if(index == 'console')
                            {
                                console.log(value);
                            }
                            else
                            {
                                $("#login-tab [name='"+index+"']").siblings('small').html(value).addClass("alert alert-danger").show();
                            }
                            console.error(x.status+" "+value);
                        });
                        console.error(errorResponse.location);
                    },
                    complete: function() {
                        $("#login_spinner").hide();
                    }
                });
            });

            $("#register_btn").on("click", function() {
                $.ajax({
                    type: "post",
                    url: "{{url('/register/registerAction')}}",
                    data: $("#register_form").serialize(),
                    dataType: "json",
                    success: function(e)
                    {
                        $("small").hide();
                        Swal.fire({
                            title: "",
                            text: e.success,
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#login-tab, #login_li").addClass("active");
                                $("#register-tab, #register_li").removeClass("active");
                            }
                        });
                        console.log(e.status+" "+e.success);
                    },
                    error: function(x)
                    {
                        var errorResponse = x.responseJSON || x.responseText;
                        $("small").hide();
                            $.each(errorResponse.error, function (index, value)
                            {
                                if(index == 'show_alert')
                                {
                                    Swal.fire({
                                        title: "",
                                        text: value,
                                        icon: 'error'
                                    });
                                }
                                else
                                {
                                    $("#register-tab [name='"+index+"']").siblings('small').html(value).addClass("alert alert-danger").show();
                                }
                                console.error(x.status+" "+value);
                            });
                        console.error(errorResponse.location);
                    }
                });
            });
        });
    </script>
</footer>
</html>
