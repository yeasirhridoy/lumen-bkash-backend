<?php


namespace App\PaymentGateway\BKASH\v1;


use Illuminate\Support\Facades\Log;

class CreatePayment
{
    private $amount;
    private $currency = 'BDT';
    private $intent = 'sale';


    public function createPayment()
    {
        $invoice = uniqid();
        $body = array('amount' => $this->amount, 'currency' => $this->currency, 'merchantInvoiceNumber' => $invoice, 'intent' => $this->intent);
        $url = env('BKASH_BASE_URL') . '/checkout/payment/create';
        Log::info('URL');
        Log::debug($url);
        $url = curl_init($url);

        $body = json_encode($body);
        Log::info('body');
        Log::debug($body);

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
        Log::info('response');
        Log::debug($resultData);
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
