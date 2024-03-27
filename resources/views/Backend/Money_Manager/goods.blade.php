<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
</head>
<body>
@include('Backend.Sections.header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Məhsullar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('Backend.Home')}}">Ana Səhifə</a></li>
                    <li class="breadcrumb-item active">Məhsullar</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#goods_add"><i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="card collapsed-card" style="border: 1px solid {{Border_Random_Color()}}">
                <div class="card-header">
                    <h3 class="card-title">Sud</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="overflow: auto; white-space: nowrap;">

                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-secondary" style="float: left;" data-toggle="modal" data-target="#user_edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button type="button" class="btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#user_ban"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Backend.Sections.footer')
</body>
</html>
