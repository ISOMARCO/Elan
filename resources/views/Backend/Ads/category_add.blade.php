<form method="post" id="category_add_form" enctype="multipart/form-data">
    <div class="modal fade" id="create_category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kateqoriya əlavə et</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Ad" id="name" autocomplete="off">
                        <div class="input-group-append">
                            <label for="name" class="input-group-text"><i class="fa-solid fa-text-width"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="parent" class="form-control" id="parent">
                            <option value="">-</option>
                            @foreach($allCategory as $value)
                                <option value="{{$value->Id}}">{{$value->Name}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <label for="parent" class="input-group-text"><i class="fa-solid fa-arrow-turn-up"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="status" class="form-control" id="status">
                            <option value="ACTIVE" selected>Aktiv</option>
                            <option value="DEACTIVE">Deaktiv</option>
                        </select>
                        <div class="input-group-append">
                            <label for="status" class="input-group-text"><i class="fa-solid fa-unlock-keyhole"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" id="img" class="form-control" name="img" accept=".png, .jpg, .svg, .jpeg">
                        <div class="input-group-append">
                            <label for="img" class="input-group-text"><i class="fa-regular fa-image"></i></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close"><i class="fa-regular fa-circle-xmark fa-lg"></i></button>
                    <button type="button" class="btn btn-primary" id="category_add_btn"><i class="fa-regular fa-floppy-disk fa-lg" id="saveIcon"></i> <i class="fa-solid fa-spinner fa-spin-pulse" style="display: none;" id="progress"></i></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @csrf
</form>
