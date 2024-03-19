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
                    <button data-toggle="modal" data-target="#create_category" class="btn btn-outline-primary">Create Category <i class="fas fa-plus"></i></button>&nbsp;
                    <button type="button" class="btn btn-outline-secondary" id="searchButton">Search <i class="fas fa-search"></i></button>
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3" id="searchBody" style="display:none">
                    <div class="col-2"><input type="text" name="qaime" class="form-control" placeholder="Qaimə №" autocomplete="off"></div>
                    <div class="col-3"><input type="date" name="tarix" id="tarix" class="form-control"></div>
                    <div class="col-3">
                        <select class="select2" name="musteri" style="width:100%">
                            <option value="">Heç biri</option>
                            <option value="Ismayil">Ismayil</option>

                        </select>
                    </div>
                    <div class="col-3">
                        <select class="select2" id="select2" name="erazi" style="width:100%">
                            <option value="">Heç biri</option>
                            <option value="Baku">Baku</option>
                        </select>
                    </div>
                    <div class="col-1"><button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button></div>
                </div>
                <div class="card collapsed-card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-1 col-sm-1">
                                <a href="javascript:void(0)"><i class="fas fa-arrow-circle-right fa-lg"></i></a>
                            </div>
                            <div class="col-10 col-sm-10">
                                <h3 class="card-title font-weight-bold">
                                    <img src="{{asset('Assets/Backend/img/Category/apple_music.svg')}}" alt="Apple Music" style="width:25px;height:25px;">
                                    Name
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

                        Body olacaq


                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" style="float:left">Edit&nbsp;<i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" style="float:right" onclick="return confirm('Are you sure?')">Delete&nbsp;<i class="fas fa-trash"></i></button>
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
