<?php

namespace App\Http\Controllers\Backend\Users;
use App\Http\Controllers\Controller;
use App\Models\Backend\Users\Users;
use Illuminate\Http\Request;
use App\Exceptions\Backend\Users\UsersException;
use App\Models\Backend\Users\User_Status_History;

class UsersController extends Controller
{
    public function main()
    {
        $users = new Users();
        $userList = $users->allUsers();
        return view('Backend.Users.main', compact('userList'));
    }

    public function saveChangesAction(Request $request)
    {
        if($request->ajax() || $request->wantsJson())
        {
            $users = new Users();
            $id = $request->post('user_number');
            $name = $request->post('name');
            $surname = $request->post('surname');
            $email = $request->post('email');
            try
            {
                $users->name($name)->surname($surname)->email($email)->id($id);
                $users->changeUser();
                return response()->json(['success' => 'İstifadəçi dəyişdirildi', 'id' => $id, 'name' => $name, 'surname' => $surname, 'email' => $email]);
            }
            catch(UsersException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }
        abort(403, 'Unauthorized');
    }

    public function changeUserStatusAction(Request $request)
    {
        if($request->ajax() || $request->wantsJson())
        {
            $userStatusHistory = new User_Status_History();
            $toStatus = $request->post('toStatus');
            $userId = $request->post('user_number');
            try
            {
                $userStatusHistory->userId($userId)->fromStatus($request->post('fromStatus'))->toStatus($toStatus)->reason($request->post('reason'));
                $userStatusHistory->changeStatus();
                return response()->json(['success' => 'İstifadəçi statusu dəyişdirildi', 'id' => $userId, 'status' => $toStatus]);
            }
            catch(UsersException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        abort(403, 'Unauthorized');
    }

    public function deactive()
    {
        $users = new Users();
        $userList = $users->allUsers(false);
        return view('Backend.Users.deactive', compact('userList'));
    }

    public function createAction(Request $request)
    {
        if($request->ajax() || $request->wantsJson())
        {

            $users = new Users();
            $name = $request->post('name');
            $surname = $request->post('surname');
            $email = $request->post('email');
            $password = $request->post('password');
            $passwordRepeat = $request->post('password_repeat');
            try
            {
                $users->name($name)->surname($surname)->email($email)->password($password)->password_repeat($passwordRepeat);
                $user = $users->createUser();
                return response()->json([
                    'success' => 'İstifadəçi əlavə olundu',
                    'name' => $user->Name,
                    'user_number' => $user->Id,
                    'user_number_formatted' => sprintf("%08d", $user->Id),
                    'surname' => $user->Surname,
                    'email' => $user->Email,
                    'status' => $user->Status,
                    'phone_number' => $user->Phone_Number,
                    'registration_date' => $user->Registration_Date,
                    'last_login_date' => $user->Last_Login_Date,
                    'gender' => $user->Gender,
                    'role' => $user->Role
                ]);
            }
            catch(UsersException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        abort(403, 'Unauthorized');
    }
}
