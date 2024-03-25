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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">12345 - Sud</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <input type="number" class="form-control" id="qty">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger" style="float: right" id="plus_button"><i class="fa-solid fa-circle-minus"></i></button>
                <button type="button" class="btn btn-success" style="float: left;" id="minus_button"><i class="fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
    </div>
    @include('Backend.Sections.footer')
    <script src="{{asset('Assets/Backend/js/barcodeDetection.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(document).on("click", "#plus_button", function(){
               var qtyVal = $(this).closest('.card').find('#qty');
               qtyVal.val(parseInt(qtyVal.val()) + 1);
            });
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
        // function docReady(fn) {
        //     // see if DOM is already available
        //     if (document.readyState === "complete"
        //         || document.readyState === "interactive") {
        //         // call on next available tick
        //         setTimeout(fn, 1);
        //     } else {
        //         document.addEventListener("DOMContentLoaded", fn);
        //     }
        // }

        //docReady(function () {

        //});
    </script>
</body>
</html>
