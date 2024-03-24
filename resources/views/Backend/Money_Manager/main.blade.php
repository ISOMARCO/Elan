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
        <div id="qr-reader" class="col-12"></div>
        <div id="qr-reader-results"></div>
    </div>
    @include('Backend.Sections.footer')
    <script src="{{asset('Assets/Backend/js/barcodeDetection.min.js')}}"></script>
    <script>
        var qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
            // Square QR Box, with size = 80% of the min edge.
            var minEdgeSizeThreshold = 250;
            var edgeSizePercentage = 0.75;
            var minEdgeSize = (viewfinderWidth > viewfinderHeight) ?
                viewfinderHeight : viewfinderWidth;
            var qrboxEdgeSize = Math.floor(minEdgeSize * edgeSizePercentage);
            if (qrboxEdgeSize < minEdgeSizeThreshold) {
                if (minEdgeSize < minEdgeSizeThreshold) {
                    return {width: minEdgeSize, height: minEdgeSize};
                } else {
                    return {
                        width: minEdgeSizeThreshold,
                        height: minEdgeSizeThreshold
                    };
                }
            }
            return {width: qrboxEdgeSize, height: qrboxEdgeSize};
        }
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
                    $("#qr-reader-results").html(`${decodedText}`, decodedResult);
                    // Handle on success condition with the decoded message.
                    //console.log(`Scan result ${decodedText}`, decodedResult);
                }
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", { fps: 10, qrbox: qrboxFunction, experimentalFeatures: {
                        useBarCodeDetectorIfSupported: true
                    }, showTorchButtonIfSupported: true});
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
</body>
</html>
