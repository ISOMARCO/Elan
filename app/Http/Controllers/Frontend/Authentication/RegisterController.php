<?php

namespace App\Http\Controllers\Frontend\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Authentication\Users;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function main() : String
    {
        return view('Frontend.Login.main');
    }

    public function registerAction(Request $request)
    {
        if ($request->ajax() || $request->wantsJson())
        {
            $name = $request->post('name');
            $surname = $request->post('surname');
            $phoneNumber = $request->post('phone_number');
            $email = $request->post('email');
            $gender = $request->post('gender');
            $password = $request->post('password');
            $repeatPassword = $request->post('repeat_password');

            $users = new Users();
            $checkEmpty = [
                'name' => $name,
                'surname' => $surname,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'password' => $password,
                'repeat_password' => $repeatPassword
            ];
            $emptyErrorArray = [];
            foreach($checkEmpty as $key => $value)
            {
                if($value == NULL)
                {
                    $emptyErrorArray[$key] = $users->String_Replace($key)." boş buraxıla bilməz";
                }
            }
            if(count($emptyErrorArray) > 0)
            {
                return response()->json(['error' => $emptyErrorArray, 'location' => 'RegisterController@registerAction@47'], 422);
            }
            if($password != $repeatPassword)
            {
                return response()->json(['error' => ['password' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır', 'repeat_password' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır'], 'location' => 'RegisterController@registerAction@51'], 422);
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                return response()->json(['error' => ['email' => 'Email adresi doğru yazılmayıb'], 'location' => 'RegisterController@registerAction@55'], 422);
            }
            $register = $users->RegisterUser([
                'name' => $name,
                'surname' => $surname,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'gender' => $gender,
                'password' => $password
            ]);
            if($register[0] === false && $register[1]['type'] === 'duplicate')
            {
                return response()->json(['error' => [$register[1]['key'] => $users->String_Replace($register[1]['key']).' artıq qeydiyyatdan keçib'], 'location' => 'RegisterController@registerAction@67'], 422);
            }
            elseif($register[0] === false && !isset($register[1]))
            {
                return response()->json(['error' => ['show_alert' => 'Bilinməyən xəta'], 'location' => 'RegisterController@registerAction@70'], 422);
            }
            return response()->json(['success' => 'Uğurla qeydiyyatdan keçdiniz. Giriş edə bilərsiniz.'], 200);

        }
        else
        {
            return abort(403, 'Unauthorized');
        }
    }
}
