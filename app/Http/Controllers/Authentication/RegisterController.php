<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Authentication\Users;

class RegisterController extends Controller
{
    public function main()
    {
        return view('Frontend.Login.main');
    }

    public function registerAction(Request $request) : void
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
            if($password != $repeatPassword)
            {
                echo json_encode(['error' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır', 'fields' => ['password', 'repeat_password']]);
                exit;
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo json_encode(['error' => 'Email adresi doğru yazılmayıb', 'fields' => ['email']]);
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
            if($register)
            {
                echo json_encode(['success' => 'Qeydiyyatdan keçdiniz.']);
                exit;
            }
            echo json_encode(['error' => 'Bilinməyən xəta', 'fields' => ['name']]);
            exit;

        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
