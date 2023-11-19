<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Authentication\Users;

class RegisterController extends Controller
{
    public function main() : String
    {
        return view('Frontend.Login.main');
    }

    public function registerAction(Request $request) : String
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
                return response()->json(['error' => $emptyErrorArray], 422);
            }
            if($password != $repeatPassword)
            {
                return response()->json(['error' => ['password' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır', 'repeat_password' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır']], 422);
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                return response()->json(['error' => ['email' => 'Email adresi doğru yazılmayıb']], 422);
            }
            $register = $users->RegisterUser([
                'name' => $name,
                'surname' => $surname,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'gender' => $gender,
                'password' => $password
            ]);
            if($register[0] === false)
            {
                return response()->json(['error' => [$register[1]['key'] => $users->String_Replace($register[1]['key']).' artıq qeydiyyatdan keçib']], 422);
            }
            return response()->json(['success' => 'Uğurla qeydiyyatdan keçdiniz. Giriş edə bilərsiniz.'], 200);

        }
        else
        {
            return abort(403, 'Unauthorized');
        }
    }
}
