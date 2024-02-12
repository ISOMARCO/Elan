<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
</head>
<body style="overflow: hidden;">
    @include('Backend.Sections.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>İstifadəçilər</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/admin/home')}}">Ana Səhifə</a></li>
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
                            <h3 class="card-title"><b>{{sprintf("%08d", $value->Id)}}</b> {{$value->Name}} {{$value->Surname}}</h3>
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
                            <table class="table table-bordered">
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-outline-secondary" style="float: left;" data-toggle="modal" data-target="#user_edit"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-outline-danger" style="float: right;"><i class="fas fa-ban"></i></button>
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    @include('Backend.Users.user_edit', ['editUser' => $value])
                @endforeach
            </div>
        </div>
    </section>
    @include('Backend.Sections.footer')
<script>
    $(document).ready(function(){

    });
</script>
</body>
</html>
