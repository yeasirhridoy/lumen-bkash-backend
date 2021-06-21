<?php


namespace App\Modules\v1;


class ExecutePayment
{
    private $paymentId;

    public function executePayment()
    {
        $url = curl_init(env('BKASH_BASE_URL') . '/checkout/payment/execute/' . $this->paymentId);

        $token = Token::get();

        $header = array(
            'Content-Type:application/json',
            'authorization:' . $token,
            'x-app-key:' . env('BKASH_APP_KEY')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);

        $resultData = curl_exec($url);
        curl_close($url);

        return $resultData;
    }

    public function setPaymentId($paymentId){
        $this->paymentId = $paymentId;
        return $this;
    }
}
