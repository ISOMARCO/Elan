<?php

namespace App\Http\Controllers\Backend\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Backend\Authentication\Users;
use Illuminate\Http\Request;
use App\Exceptions\Backend\Authentication\Authentication;
class LoginController extends Controller
{
    public function main()
    {
        return view('Backend.Login.main');
    }

    public function loginAction(Request $request)
    {
        if($request->ajax() || $request->wantsJson())
        {
            $email = $request->post('email');
            $password = $request->post('password');
            try
            {
                return response()->json(['success' => 'Okeydi bu']);
                $users = new Users();
                $users->login($email, $password);
                return response()->json(['success' => 'Okeydi']);
            }
            catch(Authentication $e)
            {
                return response()->json(['error' => 'errordu bu'], 1000);
            }
        }
        abort(403, 'Unauthorized');
    }
}
