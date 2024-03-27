<form method="post" id="goods_add_form">
    <div class="modal fade" id="goods_add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Əlavə et</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
                    <button type="button" class="btn btn-primary" id="goods_add_btn">Yadda saxla <i class="fa-solid fa-spinner fa-spin-pulse" style="display: none;" id="progress"></i></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @csrf
</form>
