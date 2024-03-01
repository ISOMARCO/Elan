<?php

namespace App\Http\Controllers\Backend\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Backend\Authentication\Users;
use Illuminate\Http\Request;
use App\Exceptions\Backend\Authentication\AuthenticationException;
class LoginController extends Controller
{
    public function main() : String
    {
        return view('Backend.Login.main');
    }

    public function loginAction(Request $request)
    {
        if($request->ajax() || $request->wantsJson())
        {
            $email = $request->post('email');
            $password = $request->post('password');
            $users = new Users();
            try
            {
                $users->login($email, $password);
                return response()->json(['success' => 'Ana səhifəyə yönləndirilirsiniz...']);
            }
            catch(AuthenticationException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        abort(403, 'Unauthorized');
    }

    public function logout()
    {
        $users = new Users();
        $users->logout();
        return redirect()->route('Backend_Login');
    }
}
