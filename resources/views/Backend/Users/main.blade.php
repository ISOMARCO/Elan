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
                @endforeach
            </div>
        </div>
    </section>
    <div class="modal fade" id="user_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @include('Backend.Sections.footer')
</body>
</html>
