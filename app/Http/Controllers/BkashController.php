<?php

namespace App\Http\Controllers;

use App\Modules\v1\Capture;
use App\Modules\v1\CreatePayment;
use App\Modules\v1\ExecutePayment;
use App\Modules\v1\QueryPayment;
use App\Modules\v1\Search;
use App\Modules\v1\Token;
use App\Modules\v1\VoidPayment;
use Illuminate\Http\Request;

class BkashController extends Controller
{

    public function token()
    {
        return Token::get();
    }

    public function createPayment(Request $request)
    {
        $rules = [
            'Amount' => 'required|numeric|min:10'
        ];
        $this->validate($request, $rules);

        $amount = $request->Amount;
        $currency = $request->Currency ?? 'BDT';
        $intent = $request->Intent ?? 'sale';
        $payment = new CreatePayment();
        return $payment->setAmount($amount)->setCurrency($currency)->setIntent($intent)->createPayment();
    }

    public function executePayment($paymentId)
    {
        $payment = new ExecutePayment();
        return $payment->setPaymentId($paymentId)->executePayment();
    }

    public function queryPayment($paymentId)
    {
        $payment = new QueryPayment();
        return $payment->setPaymentId($paymentId)->queryPayment();
    }

    public function capture($paymentId)
    {
        $payment = new Capture();
        return $payment->setPaymentId($paymentId)->capture();
    }

    public function void($paymentId)
    {
        $payment = new VoidPayment();
        return $payment->setPaymentId($paymentId)->void();
    }

    public function search($transactionId)
    {
        $payment = new Search();
        return $payment->setTransactionId($transactionId)->search();
    }
}
