<?php


namespace App\Modules\v1;


class QueryPayment
{
    private $paymentId;
    public function queryPayment()
    {
        $url = curl_init(env('BKASH_BASE_URL') . '/checkout/payment/query/' . $this->paymentId);
        $token = Token::get();
        $header = array(
            'Content-Type:application/json',
            'authorization:' . $token,
            'x-app-key:' . env('BKASH_APP_KEY')
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultDatax = curl_exec($url);

        curl_close($url);
        $result = json_decode($resultDatax, true);

        return $result;
    }

    public function setPaymentId($paymentId){
        $this->paymentId = $paymentId;
        return $this;
    }
}
