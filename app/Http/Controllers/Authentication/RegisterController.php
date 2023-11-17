<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function main()
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
            $gender = $request->post('gender');
            $password = $request->post('password');
            $repeatPassword = $request->post('repeat_password');
            if($password != $repeatPassword)
            {
                echo json_encode(['error' => 'Şifrə ilə şifrə təkrarı eyni olmalıdır', 'fields' => ['password', 'repeat_password']]);
                exit;
            }
        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
