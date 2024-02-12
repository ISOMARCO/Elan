<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\Backend\Users\Users;
use Illuminate\Http\Request;

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
            $email = $request->post('email');
            return response()->json(['success' => $email], 200);
        }
        abort(403, 'Unauthorized');
    }
}
