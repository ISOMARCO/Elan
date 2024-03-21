<form method="post" id="category_add_form">
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
                            <label for="name" class="input-group-text"><i class="fas fa-text-width"></i></label>
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
                            <label for="parent" class="input-group-text"><i class="fas fa-level-up-alt"></i></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
                    <button type="button" class="btn btn-primary" id="user_add_btn">Yadda saxla <i class="fas fa-spinner fa-spin" style="display: none;" id="progress"></i></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    @csrf
</form>
