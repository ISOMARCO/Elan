<!doctype html>
<html lang="en">
<head>
    @include('Backend.Sections.head')
    <style>
        #reader {
            width: 100%;
        }
        .empty {
            display: block;
            width: 100%;
            height: 20px;
        }

    </style>
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
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#goods_add" id="goods_add_btn"><i class="fa-solid fa-plus"></i></button>
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
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="barcode" name="barcode" value="23343434242" disabled>
                        <div class="input-group-append">
                            <label for="barcode" class="input-group-text"><i class="fa-solid fa-barcode"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="price" name="price" value="1.20" disabled>
                        <div class="input-group-append">
                            <label for="price" class="input-group-text"><i class="fa-solid fa-money-bill-wave"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="tax" name="tax" value="18" disabled>
                        <div class="input-group-append">
                            <label for="tax" class="input-group-text"><i class="fa-solid fa-receipt"></i></label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-secondary" style="float: left;" data-toggle="modal" data-target="#user_edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button type="button" class="btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#user_ban"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
            @include('Backend.Money_Manager.goods_add')
        </div>
    </div>
</section>
@include('Backend.Sections.footer')
<script src="{{asset('Assets/Backend/js/barcodeDetection.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", "#goods_add_btn", function(){
            var qrboxFunction = function(viewfinderWidth, viewfinderHeight)
            {
                var minEdgeSizeThreshold = 250;
                var edgeSizePercentage = 0.50;
                var minEdgeSize = (viewfinderWidth > viewfinderHeight) ?
                    viewfinderHeight : viewfinderWidth;
                var qrboxEdgeSize = Math.floor(minEdgeSize * edgeSizePercentage);
                if (qrboxEdgeSize < minEdgeSizeThreshold)
                {
                    if (minEdgeSize < minEdgeSizeThreshold) {
                        return {width: minEdgeSize, height: minEdgeSize};
                    } else {
                        return {
                            width: (minEdgeSizeThreshold-150)*2,
                            height: minEdgeSizeThreshold-150
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
            html5QrcodeScanner.clear();
            var lastResult, countResults = 0;
            function onScanSuccess(decodedText, decodedResult)
            {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    $("#goods_add_form #barcode").val(decodedResult.decodedText);
                    html5QrcodeScanner.stop();
                }

            }
            html5QrcodeScanner.render(onScanSuccess);
            $(document).on("click", function()
            {
                if($(event.target).is($("#goods_add_form #goods_add")) || $(event.target).is('#goods_add_form .close') || $(event.target).is('#goods_add_form #modal-close'))
                {
                    html5QrcodeScanner.clear();
                }
            });
        });
    });
</script>
</body>
</html>
