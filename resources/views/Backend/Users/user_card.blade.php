<div class="card collapsed-card card{{$user->Id}}" style="border: 1px solid {{Border_Random_Color()}}">
    <div class="card-header">
        <h3 class="card-title"><b>{{sprintf("%08d", $user->Id)}}</b> <span id="name{{$user->Id}}">{{$user->Name}}</span> <span id="surname{{$user->Id}}">{{$user->Surname}}</span></h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="overflow: auto; white-space: nowrap;">
        <table class="table table-bordered" id="table{{$user->Id}}">
            <thead>
            <tr>
                <td colspan="7" style="text-align: center; font-weight: bold;">İstifadəçi məlumatları</td>
            </tr>
            <tr>
                <th><i class="fas fa-male"></i> Ad</th>
                <th><i class="fas fa-male"></i> Soyad</th>
                <th><i class="fas fa-envelope"></i> Email</th>
                <th><i class="fas fa-phone"></i> Telefon nömrəsi</th>
                <th><i class="fas fa-calendar-alt"></i> Qeydiyyat tarixi</th>
                <th><i class="fas fa-calendar-alt"></i> Son giriş tarixi</th>
                <th><i class="fas fa-venus-mars"></i> Cins</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$user->Name}}</td>
                <td>{{$user->Surname}}</td>
                <td>{{$user->Email}}</td>
                <td>{{$user->Phone_Number}}</td>
                <td>@Date_To_String($user->Registration_Date)</td>
                <td>@Date_To_String($user->Last_Login_Date)</td>
                <td>{{$user->Gender}}</td>
                <td style="display: none">{{$user->Id}}</td>
                <td style="display: none;">{{$user->Status}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="button" id="edit_user_btn" class="btn btn-outline-secondary" style="float: left;" data-toggle="modal" data-target="#user_edit"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-outline-danger" style="float: right;" data-toggle="modal" data-target="#user_ban"><i class="fas fa-ban"></i></button>
    </div>
    <!-- /.card-footer-->
</div>
