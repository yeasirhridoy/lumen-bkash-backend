<?php


namespace App\PaymentGateway\BKASH\v1;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Token
{
    private static $tokenKey = 'bkash_auth_token';
    private static $tokenDuration = 3000;

    public static function get()
    {
        $token = Cache::remember(self::$tokenKey, self::$tokenDuration, function () {
            return (new self())->createToken();
        });

        Log::info('token');
        Log::debug(json_encode($token));

        return $token['id_token'];
    }

    private function createToken()
    {
        $body = array(
            'app_key' => env('BKASH_APP_KEY'),
            'app_secret' => env('BKASH_APP_SECRET')
        );

        $url = env('BKASH_BASE_URL') . 'checkout/token/grant';

        Log::info('url');
        Log::debug($url);

        $url = curl_init($url);

        $body = json_encode($body);
        $header = array(
            'Content-Type:application/json',
            'password:' . env('bkash_password'),
            'username:' . env('bkash_username')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $body);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);
        curl_close($url);
        $response = json_decode($resultData, true);

        Log::info('body');
        Log::debug($body);

        return $response;
    }
}
