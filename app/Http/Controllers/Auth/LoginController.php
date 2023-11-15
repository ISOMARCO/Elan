<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Auth\Users;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function main()
    {

        return view('Frontend.Login.main');
    }

    public function loginAction(Request $request) : void
    {
        if ($request->ajax() || $request->wantsJson()) {
            dd('ok');
        } else {
            abort(403, 'Unauthorized');
        }
    }
}
