<form method="post" id="user_add_form">
    <div class="modal fade" id="create_category">
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
                        <input type="text" class="form-control" name="name" placeholder="Ad" id="name" autocomplete="off">
                        <div class="input-group-append">
                            <label for="name" class="input-group-text"><i class="fas fa-user"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="surname" placeholder="Soyad" id="surname" autocomplete="off">
                        <div class="input-group-append">
                            <label for="surname" class="input-group-text"><i class="fas fa-user"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off">
                        <div class="input-group-append">
                            <label for="email" class="input-group-text"><i class="fas fa-envelope"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Şifrə">
                        <div class="input-group-append">
                            <label for="password" class="input-group-text"><i class="fas fa-lock"></i></label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_repeat" id="password_repeat" placeholder="Şifrə təkrarı">
                        <div class="input-group-append">
                            <label for="password_repeat" class="input-group-text"><i class="fas fa-lock"></i></label>
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
