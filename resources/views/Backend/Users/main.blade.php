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
        @foreach($userList as $value)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-sort-numeric-up-alt"></i> İstifadəçi nömrəsi: <b>{{sprintf("%08d", $value->Id)}}</b></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
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
                            <td>{{$value->Registration_Date}}</td>
                            <td>{{$value->Last_Login_Date}}</td>
                            <td>{{$value->Gender}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="button" class="btn btn-outline-primary" style="float: left;"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-outline-danger" style="float: right;"><i class="fas fa-ban"></i></button>
            </div>
            <!-- /.card-footer-->
        </div>
        @endforeach
    </section>
    @include('Backend.Sections.footer')
</body>
</html>
