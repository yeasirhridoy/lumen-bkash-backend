<?php


namespace App\Modules\v1;


class Search
{
    private $transactionId;

    public function search()
    {
        $token = Token::get();
        $url = curl_init(env('BKASH_BASE_URL') . '/checkout/payment/search/' . $this->transactionId);
        $header = array(
            'Content-Type:application/json',
            'authorization:' . $token,
            'x-app-key:' . env('BKASH_APP_KEY')
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdatax = curl_exec($url);
        curl_close($url);
        return $resultdatax;
    }

    public function setTransactionId($transactionId){
        $this->transactionId = $transactionId;
        return $this;
    }
}
