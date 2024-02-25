<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function main()
    {
        $a = file_get_contents('https://monitoring.e-kassa.gov.az/#/index?doc=AobqSzhrcHDM');
        echo json_encode($a, true);
        return view('Backend.Home.main');
    }
}
