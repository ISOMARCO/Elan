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
        <div class="row">
            <div class="col-12">
                <div class="card" style="height: 90vh; overflow: auto; padding: 2%;">
                    <div class="card-header">
                        <h3 class="card-title">Fixed Header Table</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Email</th>
                                <th>Cins</th>
                                <th>Vəzifə</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($userList as $value)
                                <tr data-widget="expandable-table" aria-expanded="false" style="border: 1px solid skyblue;">
                                    <td>{{$value->Id}}</td>
                                    <td>{{$value->Name}}</td>
                                    <td>{{$value->Surname}}</td>
                                    <td>{{$value->Email}}</td>
                                    <td>{{$value->Gender}}</td>
                                    <td>{{$value->Role}}</td>
                                </tr>
                                <tr class="expandable-body" style="white-space: initial; border: 1px solid skyblue;">
                                    <td colspan="6">
                                        <p>
                                            <span>
                                                Qeydiyyat tarixi: {{$value->Registration_Date}}<br>
                                                Son giriş tarixi: {{$value->Last_Login_Date}}
                                            </span>
                                            <button type="button" class="btn btn-outline-primary">Düzəliş et</button>
                                            <button type="button" class="btn btn-outline-danger" style="float: right;">Ban</button>
                                        </p>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
    @include('Backend.Sections.footer')
</body>
</html>
