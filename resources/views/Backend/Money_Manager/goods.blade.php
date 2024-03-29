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
            <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#goods_add" id="goods_add_card"><i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="card-body">
            @foreach($all as $value)
            <div class="card collapsed-card" style="border: 1px solid {{Border_Random_Color()}}">
                <div class="card-header">
                    <h3 class="card-title">{{$value->Name}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="overflow: auto; white-space: nowrap;">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="barcode" name="barcode" value="{{$value->Barcode}}" disabled>
                        <div class="input-group-append">
                            <label for="barcode" class="input-group-text"><i class="fa-solid fa-barcode"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="price" name="price" value="{{$value->Price}}" disabled>
                        <div class="input-group-append">
                            <label for="price" class="input-group-text"><i class="fa-solid fa-money-bill-wave"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="tax" name="tax" value="{{$value->Tax}}" disabled>
                        <div class="input-group-append">
                            <label for="tax" class="input-group-text"><i class="fa-solid fa-receipt"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="date" value="@Date_To_String($value->Created_Date)" disabled>
                        <div class="input-group-append">
                            <label for="date" class="input-group-text"><i class="fa-regular fa-calendar-days"></i></label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-secondary" style="float: left;" data-toggle="modal" data-target="#user_edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button type="button" class="btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#user_ban"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
            @endforeach
            @include('Backend.Money_Manager.goods_add')
        </div>
    </div>
</section>
@include('Backend.Sections.footer')
<script src="{{asset('Assets/Backend/js/barcodeDetection.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", "#goods_add_card", function(){
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
                "reader",
                {
                    fps: 5,
                    qrbox: qrboxFunction,
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true,
                    aspectRatio: 1.777778,
                    disableFlip: false,
                    facingMode: {exact: "environment"},
                    formatsToSupport: [
                        Html5QrcodeSupportedFormats.EAN_13,
                        Html5QrcodeSupportedFormats.ITF
                    ],
                    focusMode: "continuous",
                    defaultZoomValueIfSupported: 2
                });
            html5QrcodeScanner.clear();
            var lastResult, countResults = 0;
            function onScanSuccess(decodedText, decodedResult)
            {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    $("#goods_add_form #barcode").val(decodedResult.decodedText);
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

        $(document).on("click", "#goods_add_btn", function(){
            $.ajax({
                type: "POST",
                url: "{{route('Backend.Money_Manager_CreateAction')}}",
                data: $("#goods_add_form").serialize(),
                dataType: "json",
                beforeSend: function()
                {
                    $("#goods_add_form #progress").show();
                    $("#goods_add_form input, #goods_add_btn").attr("disabled", "disabled");
                },
                error: function(x)
                {
                    var errorResponse = x.responseJSON || x.responseText;
                    Swal.fire({
                        title: '',
                        text: errorResponse.error,
                        icon: 'error'
                    });
                },
                success: function(e)
                {
                    Swal.fire({
                        title: '',
                        text: e.success,
                        icon: 'success'
                    });
                },
                complete: function()
                {
                    $("#goods_add_form #progress").hide();
                    $("#goods_add_form input, #goods_add_btn").removeAttr("disabled");
                }
            });
        });
    });
</script>
</body>
</html>
