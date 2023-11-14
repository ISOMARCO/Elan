<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
class HomeController extends Controller
{
    public function main()
    {
        foreach(Users::where("Id", '1')->get() as $value)
        {
            echo $value->Name." ".$value->Surname."<br>";
        }
        return view('Frontend.Home.main');
    }
}
