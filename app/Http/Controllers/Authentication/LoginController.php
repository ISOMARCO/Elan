<?php
namespace App\Http\Controllers\Authentication;
use App\Http\Controllers\Controller;
use App\Models\Authentication\Users;
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
            $email_or_phone = $request->post('email_or_phone');
            $password = $request->post('password');
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
                return response()->json(['error' => $emptyErrorArray, 'location' => 'LoginController@loginAction@34'], 422);
            }
            $user = $users->login($email_or_phone, $password);
            if($user[0] === false)
            {
                return response()->json(['error' => 'Giriş məlumatları doğru deyil', 'show_alert' => true, 'location' => 'LoginController@loginAction@39'], 422);
            }
        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
