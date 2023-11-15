<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function main()
    {
        return view('Frontend.Login.main');
    }

    public function loginAction(Request $request) : void
    {
        echo "OK";
    }
}
