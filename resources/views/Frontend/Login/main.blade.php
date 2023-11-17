<!DOCTYPE html>
<html lang="en">
<head>
    @include('Frontend.Login.Sections.head')
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
            <div class="user-form-title"><h2>Welcome!</h2>
                <p>Use credentials to access your account.</p></div>
            <form method="post" id="login_form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" name="email_or_phone" class="form-control" placeholder="Email or Phone">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="pass" placeholder="Password">
                            <button type="button" class="form-icon"><i class="eye fas fa-eye"></i></button>
                            <small class="form-alert">Password must be 6 characters</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="signin-check">
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
            <div class="user-form-direction"><p>Don't have an account? click on the <span>( sign up )</span>button
                    above.</p></div>
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
                            <input type="text" class="form-control" placeholder="Phone number" name="phone_number">
                            <small class="form-alert">Please follow this example - 0501234567</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <button class="form-icon"><i class="eye fas fa-eye"></i></button>
                            <small class="form-alert">Password must be 6 characters</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Repeat Password" name="repeat_password">
                            <button class="form-icon"><i class="eye fas fa-eye"></i></button>
                            <small class="form-alert">Password must be 6 characters</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="signup-check" name="agree">
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
    <script>
        $(document).ready(function(){
            if(window.location.hash == '#register-tab' || "{{ request()->routeIs('Register') }}" == true)
            {
                $("#login-tab, #login_li").removeClass("active");
                $("#register-tab, #register_li").addClass("active");
            }
            $("#login_btn").on("click", function() {
                $.ajax({
                    type: "post",
                    url: "{{url('login/loginAction')}}",
                    data: $("#login_form").serialize(),
                    dataType: "json",
                    success: function(e)
                    {
                        console.log(e);
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
                        console.log(e);
                    }
                });
            });
        });
    </script>
</footer>
</html>
