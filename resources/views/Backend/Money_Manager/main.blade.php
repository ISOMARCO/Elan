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
        <canvas></canvas>
    </div>
    @include('Backend.Sections.footer')
    <script>
        $(document).ready(function(){
           var video = null;
           var canvas = null;
           navigator.mediaDevices.getUserMedia({video: {width: 500, height: 500}}).
               then(stream => {
               video.current.srcObject = stream;
               video.current.play();
               var ctx = canvas.current.getContext('2d');
               setInterval(() => {
                   canvas.current.width = video.current.videoWidth;
                   canvas.current.height = video.current.videoHeight;
                   ctx.drawImage(video.current, 0, 0, video.current.videoWidth, video.current.videoHeight);
               }, 100);
            }).catch(err => {
                console.log(err);
           });
        });
    </script>
</body>
</html>
