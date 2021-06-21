<?php

namespace App\Http\Controllers;

class BkashUrlBasedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function token()
    {

        $post_token = array(
            'app_key' => env('BKASH_APP_KEY'),
            'app_secret' => env('BKASH_APP_SECRET')
        );

        $url = env('BKASH_BASE_URL') . 'checkout/token/grant';
        $url = curl_init($url);

        $postToken = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            'password:' . env('bkash_password'),
            'username:' . env('bkash_username')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultData = curl_exec($url);
        curl_close($url);
        $response = json_decode($resultData, true);

        return $response;
    }

    public function createPayment()
    {
        $token = $this->token()['id_token'];
        $callbackURL = 'yourURL.com';
        $body = array(
            'mode' => '0011',
            'amount' => '10',
            'currency' => 'BDT',
            'intent' => 'sale',
            'payerReference' => '01770618575',
            'merchantInvoiceNumber' => 'commonPayment001',
            'callbackURL' => $callbackURL
        );
        $url = curl_init(env('BKASH_BASE_URL') . '/tokenized/checkout/create');
        $body = json_encode($body);

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $token,
            'X-APP-Key:' . env('BKASH_APP_KEY')
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $body);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultData = curl_exec($url);
        curl_close($url);

        $obj = json_decode($resultData, true);

//        header("Location: " . $obj->{'bkashURL'});
        return $obj;
    }

    public function executePayment()
    {
        $paymentID = "12345667";
        $token = $this->token()['id_token'];

        $post_token = array(
            'paymentID' => $paymentID
        );
        $url = curl_init('$baseURL/v1.2.0-beta/tokenized/checkout/execute');
        $posttoken = json_encode($post_token);

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $token,
            'X-APP-Key:shared_app_key'
        );
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);

        curl_close($url);

        $obj = json_decode($resultdata);
    }

    public function querypayment($paymentID)
    {
        $url = curl_init(env('BKASH_BASE_URL') . '/checkout/payment/query/' . $paymentID);
        $token = $this->token()['id_token'];
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

        if ($result['transactionStatus'] == 'Completed') {
            $data = array();
            $data['user_id'] = Auth::id();
            $data['amount'] = $result['amount'];
            $data['bank_tran_id'] = $result['trxID'];
            $data['store_amount'] = $result['amount'];
            $data['tran_id'] = $result['paymentID'];

            Payment::create($data);

            $user_id = Auth::id();

            $reference = Reference::where('user_id', $user_id)->first();

            if ($reference) {
                $reference = $reference->reference;
                $referrer = User::where('reference', $reference)->first();
                if ($referrer) {
                    $profile = $referrer->profile;
                    $bonus = $profile->bonus;
                    $total = $bonus + 50;
                    $profile->bonus = $total;
                    $profile->save();
                }
            }
            return redirect('/home');
        } else {
            return "Something went wrong. Try again...";
        }
    }
}
