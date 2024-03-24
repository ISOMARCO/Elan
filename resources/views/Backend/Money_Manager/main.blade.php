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
        <video id="stream" style="width: 300px; height: 300px;"/>
    </div>
    @include('Backend.Sections.footer')
    <script>
        $(document).ready(function(){
            (async () => {
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: {
                            ideal: "environment"
                        }
                    },
                    audio: false
                });
                const videoEl = document.querySelector("#stream");
                videoEl.srcObject = stream;
                await videoEl.play();

                const barcodeDetector = new BarcodeDetector({formats: ['code_128', 'code_39', 'code_93', 'codabar', 'ean_13', 'ean_8', 'itf', 'upc_a', 'upc_e']});
                window.setInterval(async () => {
                    const barcodes = await barcodeDetector.detect(videoEl);
                    if (barcodes.length <= 0) return;
                    //alert(barcodes.map(barcode => barcode.rawValue));
                    console.log(barcodes.map(barcode => barcode.rawValue));
                }, 1000)
            })();
        });
    </script>
</body>
</html>
