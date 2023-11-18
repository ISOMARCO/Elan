<?php
namespace App\Http\Controllers\Authentication;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
class LoginController extends Controller
{
    public function main()
    {
        echo __(en.messages.welcome);
        return view('Frontend.Login.main');
    }

    public function loginAction(Request $request)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            echo json_encode(['ok' => $request->post('email_or_phone')]);
        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
