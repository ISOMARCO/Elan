<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function main()
    {
        $suitecrm_url = 'https://suite8demo.suiteondemand.com'; // Correct: https://suitecrm.example.net // Incorrect: https://suitecrm.example.net/ .
        $client_id = 'a712fa0f-2e20-624d-8b16-62b182af16e9';
        $client_secret = 'will';

        $token_url = $suitecrm_url . '/Api/access_token';
        $module_url = $suitecrm_url . '/Api/V8/module';

// Authentication - Begin
        $ch = curl_init();
        $header = array(
            'Content-type: application/vnd.api+json',
            'Accept: application/vnd.api+json'
        );
        $postStr = json_encode(array(
            'grant_type' => 'password',
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ));
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $output = curl_exec($ch);
        #$auth_out = json_decode($output,true);

        print_r ($output); // For debug purposes
        #print_r ($auth_out); // For debug purposes
        return view('Backend.Home.main');
    }
}
