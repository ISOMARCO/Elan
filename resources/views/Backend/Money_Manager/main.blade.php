<!doctype html>
<html lang="az">
<head>
    @include('Backend.Sections.head')
</head>
<body class="hold-transition sidebar-mini">
    @include('Backend.Sections.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pul idarəsi</h1>
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
    <div class="content">
        <video autoplay muted/>
    </div>
    @include('Backend.Sections.footer')
    <script>
        $(document).ready(function(){
           const video = null;
           navigator.mediaDevices.getUserMedia({video: {width: 500, height: 500}}).
               then(stream => {
               video.current.srcObject = stream;
               video.current.play();
            }).catch(err => {
                console.log(err);
           });
        });
    </script>
</body>
</html>
