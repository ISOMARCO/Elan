<?php

namespace App\Http\Controllers\Backend\Home;

use App\Http\Controllers\Controller;
class HomeController extends Controller
{
    public function main()
    {
        $url = "https://sandbox.booknetic.com/sandboxes/sandbox-saas-6f49ae724d32a0cf3823/wp-admin/admin-ajax.php";

// POST verisi
        $data =
            array(
                'cart' =>
            array(
            'location' => -1,
            'staff' => -1,
            'service_category' => '',
            'service' => 13,
            'service_extras' => [],
            'date' => '',
            'time' => '',
            'brought_people_count' => 0,
            'recurring_start_date' => '',
            'recurring_end_date' => '',
            'recurring_times' => "{}",
            'appointments' => "[]",
            'customer_data' => (object) array()
        ),
                'action' => 'bkntc_get_data_date_time',
                'current' => '0',
                'deposit_full_amount' => '0',
                'step' => 'date_time'
            );

// curl başlat
        $ch = curl_init();

// curl ayarları
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=UTF-8', 'Access-Control-Allow-Credentials: true','Content-Encoding: br', 'X-Robots-Tag: noindex'));

// isteği yap ve cevabı al
        $response = curl_exec($ch);

// curl bağlantısını kapat
        curl_close($ch);

// cevabı ekrana yazdır
        echo $response;
        return view('Backend.Home.main');
    }
}
