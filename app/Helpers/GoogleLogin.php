<?php
namespace App\Helpers;
class GoogleLogin
{
    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) : Array
    {
        $url = "https://googleapis.com/oauth2/v4/token";
        $curlPost = http_build_query(['client_id' => $client_id, 'redirect_uri' => $redirect_uri, 'client_secret' => $client_secret, 'code' => $code, 'grant_type' => 'authorization_code']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        return json_decode(curl_exec($ch), true);
    }

    public function GetUserInfo($token)
    {
        $url = "https://googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, [$token]);
        return json_decode(curl_exec($ch), true);
    }
}
