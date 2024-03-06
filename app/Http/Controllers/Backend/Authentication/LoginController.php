<?php

namespace App\Http\Controllers\Backend\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Backend\Authentication\Users;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\Backend\Authentication\AuthenticationException;
use Illuminate\Http\RedirectResponse;
class LoginController extends Controller
{
    public function main() : String
    {
        return view('Backend.Login.main');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function loginAction(Request $request) : RedirectResponse|JsonResponse
    {
        if($request->ajax() || $request->wantsJson())
        {
            $email = $request->input('email');
            $password = $request->input('password');
            $request->only('email', 'password');
            $users = new Users();
            try
            {
                return response()->json(['success' => 'Ana səhifəyə yönləndirilirsiniz...', 'user' => $users->login($email, $password)]);
            }
            catch(AuthenticationException $e)
            {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
        abort(403, 'Unauthorized');
    }

    /**
     * @return RedirectResponse
     */
    public function logout() : RedirectResponse
    {
        $users = new Users();
        $users->logout();
        return redirect()->route('Backend.Login');
    }
}
