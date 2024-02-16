<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
    <link rel="stylesheet" href="{{asset('Assets/Backend/plugins/sweetalert2/sweetalert2.min.css')}}">
</head>
<body>
    @include('Backend.Sections.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>İstifadəçilər</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/admin/')}}">Ana Səhifə</a></li>
                        <li class="breadcrumb-item active">İstifadəçilər</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" style="float: right;"><i class="fas fa-plus"></i></button>
            </div>
            <div class="card-body">
                @foreach($userList as $value)
                    <div class="card collapsed-card" style="border: 1px solid @Border_Random_Color">
                        <div class="card-header">
                            <h3 class="card-title"><b>{{sprintf("%08d", $value->Id)}}</b> <span id="name{{$value->Id}}">{{$value->Name}}</span> <span id="surname{{$value->Id}}">{{$value->Surname}}</span></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
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
                                        <th><i class="fas fa-male"></i> Ad</th>
                                        <th><i class="fas fa-male"></i> Soyad</th>
                                        <th><i class="fas fa-envelope"></i> Email</th>
                                        <th><i class="fas fa-phone"></i> Telefon nömrəsi</th>
                                        <th><i class="fas fa-calendar-alt"></i> Qeydiyyat tarixi</th>
                                        <th><i class="fas fa-calendar-alt"></i> Son giriş tarixi</th>
                                        <th><i class="fas fa-venus-mars"></i> Cins</th>
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
                                        <td style="display: none;">{{$value->Role}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-outline-secondary" style="float: left;" data-toggle="modal" data-target="#user_edit"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#user_ban"><i class="fas fa-ban"></i></button>
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
            $("#name").val(rowData[0]);
            $("#surname").val(rowData[1]);
            $("#email").val(rowData[2]);
            $("#user_number").val(rowData[7]);
        });

        $("#user_edit_btn").on("click", function(){
            $.ajax({
                type: "post",
                url: "{{url('/admin/users/saveChangesAction')}}",
                data: $("#user_edit_form").serialize(),
                dataType: "json",
                beforeSend: function()
                {
                    $("#user_edit_form #progress").show();
                    $("#user_edit_form input, #user_edit_btn").attr("disabled", "disabled");
                },
                success: function(e)
                {
                    Swal.fire({
                        title: '',
                        text: e.success,
                        icon: 'success'
                    });
                    $("#table"+e.id+" tbody td:nth-child(1)").text(e.name);
                    $("#table"+e.id+" tbody td:nth-child(2)").text(e.surname);
                    $("#table"+e.id+" tbody td:nth-child(3)").text(e.email);
                    $("#name"+e.id).text(e.name);
                    $("#surname"+e.id).text(e.surname);
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
                    $("#user_edit_form #progress").hide();
                    $("#user_edit_form input, #user_edit_btn").removeAttr("disabled");
                }
            });
        });

        $("#user_ban_btn").on("click", function(){
            $.ajax({
                type: "post",
                url: "{{url('/admin/users/changeUserStatusAction')}}",
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
                    alert(errorResponse);
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
