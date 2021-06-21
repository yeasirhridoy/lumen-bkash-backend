<?php


namespace App\Modules\v1;


class VoidPayment
{
    private $paymentId;

    public function void()
    {
        $token = Token::get();

        $url = curl_init(env('BKASH_BASE_URL') . '/checkout/payment/void/' . $this->paymentId);
        $header = array(
            'Content-Type:application/json',
            'authorization:' . $token,
            'x-app-key:' . env('BKASH_APP_KEY')
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdatax = curl_exec($url);
        curl_close($url);
        return $resultdatax;
    }

    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
        return $this;
    }
}
