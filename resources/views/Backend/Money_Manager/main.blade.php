<!doctype html>
<html lang="az">
<head>
    @include('Backend.Sections.head')
    <style>
        #reader {
            width: 640px;
        }
        @media(max-width: 600px) {
            #reader {
                width: 300px;
            }
        }
        .empty {
            display: block;
            width: 100%;
            height: 20px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-info {
            color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        #scanapp_ad {
            display: none;
        }
        @media(max-width: 1500px) {
            #scanapp_ad {
                display: block;
            }
        }

    </style>
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
        <div class="row">
            <div class="col-12" style="text-align: center;margin-bottom: 20px;">
                <div id="reader" style="display: inline-block;"></div>
                <div class="empty"></div>
                <div id="scanned-result"></div>
            </div>
        </div>
    </div>
    @include('Backend.Sections.footer')
    <script src="{{asset('Assets/Backend/js/barcodeDetection.min.js')}}"></script>
    <script>
        function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete"
                || document.readyState === "interactive") {
                // call on next available tick
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        docReady(function () {
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;
            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    $("#scanned-result").append("<p>"+decodedResult.decodedText+"</p>");
                }
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: {width: 500, height: 250}, experimentalFeatures: {
                        useBarCodeDetectorIfSupported: true
                    },
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true});
            //html5QrcodeScanner.clear();
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
</body>
</html>
