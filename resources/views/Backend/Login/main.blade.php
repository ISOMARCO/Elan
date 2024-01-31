<!doctype html>
<html lang="en">
<head>
    @include('Backend.Login.Sections.head')
</head>
<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
    @include('Backend.Login.Sections.header')
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                <!--begin::Image-->
                <img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{asset('Assets/Backend/media/auth/agency.png')}}" alt="">
                <img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{asset("Assets/Backend/media/auth/agency-dark.png")}}" alt="">
                <!--end::Image-->

                <!--begin::Title-->
                <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
                    Fast, Efficient and Productive
                </h1>
                <!--end::Title-->

                <!--begin::Text-->
                <div class="text-gray-600 fs-base text-center fw-semibold">
                    Burada yazılar ola bilər
                </div>
                <!--end::Text-->
            </div>
            <!--end::Content-->
        </div>
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
            <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
                <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                    <div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">

                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">
                                    Admin panelə giriş
                                </h1>
                                <div class="text-gray-500 fw-semibold fs-6">
                                    Elan
                                </div>
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent">
                            </div>

                            <div class="fv-row mb-3">
                                <input type="password" placeholder="Şifrə" name="password" autocomplete="off" class="form-control bg-transparent">
                            </div>

                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                            </div>

                            <div class="d-grid mb-10">
                                <button type="button" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">Giriş</span>
                                    <span class="indicator-progress">Zəhmət olmasa gözləyin...    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Body-->
    </div>
</body>
<footer>
    @include('Backend.Login.Sections.footer')
    <script>
        $(document).ready(function()
        {
            $("#kt_sign_in_submit").on("click", function(){
                $.ajax({
                    type: "post",
                    url: "{{url('login/loginAction')}}",
                    data: $("#kt_sign_in_form").serialize(),
                    dataType: "json",
                    beforeSend: function()
                    {
                        $(".indicator-progress").show();
                    },
                    error: function(x)
                    {

                    },
                    success: function(e)
                    {

                    },
                    complete: function()
                    {
                        $(".indicator-progress").hide();
                    }
                });
            });
        });
    </script>
</footer>
</html>
