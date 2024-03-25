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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Mehsul</th>
                    <th>Input</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12345</td>
                    <td>Sud</td>
                    <td>
                        <div class="row">
                            <div class="col-8">
                                <input type="text" class="form-control" id="qty">
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-success">+</button>
                                <button type="button" class="btn btn-danger">-</button>
                            </div>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
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
            var qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
                var minEdgeSizeThreshold = 250;
                var edgeSizePercentage = 0.50;
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
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: qrboxFunction, experimentalFeatures: {
                        useBarCodeDetectorIfSupported: true
                    },
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true});
            var lastResult, countResults = 0;
            function onScanSuccess(decodedText, decodedResult)
            {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    $("#scanned-result").prepend("<p>"+decodedResult.decodedText+"</p>");
                    //html5QrcodeScanner.stop();
                }

            }
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
</body>
</html>
