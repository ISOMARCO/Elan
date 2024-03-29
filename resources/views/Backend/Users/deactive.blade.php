<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
    <link rel="stylesheet" href="{{asset('Assets/Backend/plugins/sweetalert2/sweetalert2.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
@include('Backend.Sections.header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Aktiv olmayan istifadəçilər</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('Backend.Home')}}">Ana Səhifə</a></li>
                    <li class="breadcrumb-item active">Deaktiv İstifadəçilər</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            @foreach($userList as $value)
                <div class="card collapsed-card card{{$value->Id}}" style="border: 1px solid {{Border_Random_Color()}}">
                    <div class="card-header">
                        <h3 class="card-title"><b>{{sprintf("%08d", $value->Id)}}</b> <span id="name{{$value->Id}}">{{$value->Name}}</span> <span id="surname{{$value->Id}}">{{$value->Surname}}</span></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="overflow: auto; white-space: nowrap;">
                        <table class="table table-bordered" id="table{{$value->Id}}">
                            <thead>
                            <tr>
                                <td colspan="7" style="text-align: center; font-weight: bold;">İstifadəçi məlumatları</td>
                            </tr>
                            <tr>
                                <th><i class="fa-solid fa-person"></i> Ad</th>
                                <th><i class="fa-solid fa-person"></i> Soyad</th>
                                <th><i class="fa-solid fa-envelope"></i> Email</th>
                                <th><i class="fa-solid fa-phone"></i> Telefon nömrəsi</th>
                                <th><i class="fa-regular fa-calendar-days"></i> Qeydiyyat tarixi</th>
                                <th><i class="fa-regular fa-calendar-days"></i> Son giriş tarixi</th>
                                <th><i class="fa-solid fa-venus-mars"></i> Cins</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{$value->Name}}</td>
                                <td>{{$value->Surname}}</td>
                                <td>{{$value->Email}}</td>
                                <td>{{$value->Phone_Number}}</td>
                                <td>@Date_To_String($value->Registration_Date)</td>
                                <td>@Date_To_String($value->Last_Login_Date)</td>
                                <td>{{$value->Gender}}</td>
                                <td style="display: none">{{$value->Id}}</td>
                                <td style="display: none;">{{$value->Status}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#user_ban"><i class="fa-solid fa-user-slash"></i></button>
                    </div>
                    <!-- /.card-footer-->
                </div>
            @endforeach
            @include('Backend.Users.user_edit')
            @include('Backend.Users.user_ban')
        </div>
    </div>
</section>
@include('Backend.Sections.footer')
<script src="{{asset('Assets/Backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $(".card-footer button:first-child").on("click", function(){
            var rowData = $(this).closest('.card').find('tbody td').map(function() {
                return $(this).text();
            }).get();
            $("#user_ban_form #toStatus").val(rowData[8]);
            $("#user_ban_form #fromStatus").val(rowData[8]);
            $("#user_ban_form #user_number").val(rowData[7]);
        });

        $(document).on("click", "#user_ban_btn", function(){
            $.ajax({
                type: "post",
                url: "{{route('Backend.Users_ChangeUserStatusAction')}}",
                data: $("#user_ban_form").serialize(),
                dataType: "json",
                beforeSend: function()
                {
                    $("#user_ban_form #progress").show();
                    $("#user_ban_form input, #user_ban_btn").attr("disabled", "disabled");
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
                    if(e.status !== 'ACTIVE')
                    {
                        $("#table"+e.id+" tbody td:nth-child(9)").text(e.status);
                    }
                    else
                    {
                        $(".card"+e.id).fadeOut(1000, function(){
                            $(this).remove();
                        });
                    }
                },
                complete: function()
                {
                    $("#user_ban_form #progress").hide();
                    $("#user_ban_form input, #user_ban_btn").removeAttr("disabled");
                }
            });
        });
    });
</script>
</body>
</html>
