<?php


namespace App\Modules\v1;


class CreatePayment
{
    private $amount;
    private $currency = 'BDT';
    private $intent = 'sale';


    public function createPayment()
    {
        $invoice = uniqid();
        $body = array('amount' => $this->amount, 'currency' => $this->currency, 'merchantInvoiceNumber' => $invoice, 'intent' => $this->intent);
        $url = curl_init(env('BKASH_BASE_URL') . '/checkout/payment/create');

        $body = json_encode($body);

        $token = Token::get();

        $header = array(
            'Content-Type:application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $token,
            'x-app-key:' . env('BKASH_APP_KEY')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $body);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);

        $resultData = curl_exec($url);
        curl_close($url);
        return $resultData;
    }

    public function setAmount($amount){
        $this->amount =  $amount;
        return $this;
    }

    public function setCurrency($currency){
        $this->currency =  $currency;
        return $this;
    }

    public function setIntent($intent){
        $this->intent = $intent;
        return $this;
    }
}
