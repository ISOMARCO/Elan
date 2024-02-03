<?php

namespace App\Http\Controllers\Backend\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Backend\Authentication\Users;
use Illuminate\Http\Request;
use App\Exceptions\Backend\Authentication\Authentication;
class LoginController extends Controller
{
    public function main() : String
    {
        return view('Backend.Login.main');
    }

    public function loginAction(Request $request) : String
    {
        if($request->ajax() || $request->wantsJson())
        {
            $email = $request->post('email');
            $password = $request->post('password');
            //$users = new Users();
            return response()->json(['success' => 'Okeydi'], 200);
            try
            {
                $users->login($email, $password);
                return response()->json(['success' => 'Okeydi'], 200);
            }
            catch(Authentication $e)
            {
                return response()->json(['success' => "Bu bir errordu"], 200);
            }
        }
        abort(403, 'Unauthorized');
    }
}
