<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
    <link rel="stylesheet" href="{{asset('Assets/Backend/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('Assets/Backend/plugins/select2bs4/select2-bootstrap4.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
    @include('Backend.Sections.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kateqoriyalar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('Backend.Home')}}">Ana Səhifə</a></li>
                        <li class="breadcrumb-item active">Kateqoriyalar</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <span class="float-right">
                    <button data-toggle="modal" data-target="#create_category" class="btn btn-primary"><i class="fas fa-plus"></i></button>&nbsp;
                    <button type="button" class="btn btn-secondary" id="searchButton"><i class="fas fa-search"></i></button>
                </span>
            </div>
            <div class="card-body">
                @foreach($allCategory as $value)
                <div class="card collapsed-card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-1 col-sm-1">
                                <a href="javascript:void(0)"><i class="fas fa-arrow-circle-right fa-lg"></i></a>
                            </div>
                            <div class="col-10 col-sm-10">
                                <h3 class="card-title font-weight-bold">
                                    <img src="{{asset('Assets/Backend/img/Category/'.$value->Photo)}}" alt="Apple Music" style="width:25px;height:25px;">
                                    {{$value->Name}}
                                </h3>
                            </div>
                            <div class="card-tools col-1 col-sm-1">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @include('Backend.Ads.category_add')
    </section>
    @include('Backend.Sections.footer')
    <script src="{{asset('Assets/Backend/plugins/select2/js/select2.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#parent").select2({
                theme: 'bootstrap4'
            });
            $(document).on("click", "#category_add_btn", function(){
                $.ajax({
                    type: "POST",
                    url: "{{route('Backend.Category_Create')}}",
                    dataType: "json",
                    data: $("#category_add_form").serialize(),
                    beforeSend: function()
                    {
                        $("#category_add_form #progress").show();
                        $("#category_add_form input, #category_add_btn").attr("disabled", "disabled");
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
                    success: function(e)
                    {
                        Swal.fire({
                            title: '',
                            text: e.success,
                            icon: 'success'
                        });
                        //$(".main-card").prepend(e.userCard);
                    },
                    complete: function()
                    {
                        $("#category_add_form #progress").hide();
                        $("#category_add_form input, #category_add_btn").removeAttr("disabled");
                    }
                });
            });
        });
    </script>
</body>
</html>
