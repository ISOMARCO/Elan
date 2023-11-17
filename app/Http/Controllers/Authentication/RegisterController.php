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
        if (!$request->ajax() || $request->wantsJson())
        {
            echo json_encode(['ok' => $request->post('phone_number')]);
        }
        else
        {
            abort(403, 'Unauthorized');
        }
    }
}
