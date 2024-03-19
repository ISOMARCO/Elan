<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
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
                <div class="card collapsed-card">

                    <div class="card-body">

                    </div>
                </div>
                </div>
            </div>
        </div>
        @include('Backend.Ads.category_add')
    </section>
    @include('Backend.Sections.footer')
</body>
</html>
