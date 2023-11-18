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

    public function registerAction(Request $request) : Void
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
                    $emptyErrorArray[$key] = "Bu xana boş buraxıla bilməz";
                }
            }
            if(count($emptyErrorArray) > 0)
            {
                echo json_encode(['error' => $emptyErrorArray]);
                exit;
            }
            if($password != $repeatPassword)
            {
                echo json_encode(['error' => ['password' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır', 'repeat_password' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır']]);
                exit;
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo json_encode(['error' => ['email' => 'Email adresi doğru yazılmayıb']], true);
                exit;
            }
            $users = new Users();
            $register = $users->registerUser([
                'name' => $name,
                'surname' => $surname,
                'phone_number' => $phoneNumber,
                'email' => $email,
                'gender' => $gender,
                'password' => $password
            ]);
            if($register[0] === false)
            {
                echo json_encode(['error' => [$register[1]['key'] => 'Email artıq qeydiyyatdan keçib']]);
                exit;
            }
            echo json_encode(['success' => 'Qeydiyyatdan keçdiniz.']);
            exit;

        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
