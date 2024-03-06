<?php
namespace App\Http\Controllers\Frontend\Authentication;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Authentication\Users;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function main() : String
    {
        return view('Frontend.Login.main');
    }

    public function loginAction(Request $request)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            $email_or_phone = $request->post('email_or_phone');
            $password = $request->post('password');
            $remember_me = (bool) $request->post('remember_me');
            $users = new Users();
            $checkEmpty = [
                'email_or_phone' => $email_or_phone,
                'password' => $password
            ];
            $emptyErrorArray = [];
            foreach($checkEmpty as $key => $value)
            {
                if($value == NULL)
                {
                    $emptyErrorArray[$key] = $users->String_Replace(strtolower($key))." boş buraxıla bilməz";
                }
            }
            if(count($emptyErrorArray) > 0)
            {
                return response()->json(['error' => $emptyErrorArray], 422);
            }
            $user = $users->login($email_or_phone, $password, $remember_me);
            if($user[0] === false)
            {
                switch($user[1])
                {
                    case "no_user":
                        return response()->json(['error' => ['show_alert' => 'Giriş məlumatları doğru deyil']], 422);
                    break;
                    case "undefined_email_or_phone":
                        return response()->json(['error' => ['email_or_phone' => 'Email adres və ya telefon nömrəsi yazmalısınız']], 422);
                    break;
                    default:
                        return response()->json(['error' => ['show_alert' => $user[1], 'console' => $user[1]]], 422);
                    break;
                }
            }
            $userInfo = $user[1];
            Session::put('id', $userInfo->Id);
            Cache::store('redis')->put('user_info_'.$userInfo->Id, $userInfo, 360);
            return response()->json(['success' => 'Giriş məlumatları doğrudur. Ana səhifəyə yönləndirilirsiniz...']);
        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }

    public function logout() : RedirectResponse
    {
        $users = new Users();
        $users->logout();
        return redirect()->back();
    }
}
