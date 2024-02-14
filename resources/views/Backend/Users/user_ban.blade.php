<form method="post" id="user_ban_form">
    <div class="modal fade" id="user_ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ban</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <select class="form-control" nam="status" id="status">
                            <option value="ACTIVE">Aktiv</option>
                            <option value="DEACTIVE">Deaktiv</option>
                            <option value="BAN">Ban</option>
                        </select>
                        <div class="input-group-append">
                            <label for="status" class="input-group-text"><i class="fas fa-ban"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" name="reason" id="reason"></textarea>
                        <div class="input-group-append">
                            <label for="reason" class="input-group-text"><i class="fas fa-comments"></i></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
                    <button type="button" class="btn btn-primary" id="user_ban_btn">Yadda saxla <i class="fas fa-spinner fa-spin" style="display: none;" id="progress"></i></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <input type="hidden" name="user_number" id="user_number">
    @csrf
</form>
