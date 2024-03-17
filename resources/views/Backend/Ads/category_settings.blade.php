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
                    <h1>Kateqoriya parametrləri</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('Backend.Home')}}">Ana Səhifə</a></li>
                        <li class="breadcrumb-item active">Kateqoriya parametrləri</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        boyuyende kateqoriya parametri olacaq
    </section>
    @include('Backend.Sections.footer')
</body>
</html>
