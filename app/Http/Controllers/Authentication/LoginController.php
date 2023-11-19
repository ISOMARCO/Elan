<?php
namespace App\Http\Controllers\Authentication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    public function main()
    {
        return view('Frontend.Login.main');
    }

    public function loginAction(Request $request)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            return response()->json(['ok' => $request->post('email_or_phone')], 500);
        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
