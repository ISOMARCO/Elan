<?php

namespace App\Http\Controllers\Backend\Users;
use App\Http\Controllers\Controller;
use App\Models\Backend\Users\Users;
use Illuminate\Http\Request;
use App\Exceptions\Backend\Users\Users as UsersException;

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
            try
            {
                $users->name($request->post('name'))->surname($request->post('surname'))->email($request->post('email'))->id($request->post('user_number'));
                $users->changeUser();
                return response()->json(['success' => 'İstifadəçi dəyişdirildi'], 200);
            }
            catch(UsersException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }
        abort(403, 'Unauthorized');
    }
}
