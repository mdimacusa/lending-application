<?php

namespace App\Http\Controllers\Pages\Transactions\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentServiceInterface;
use Crypt;

class PaymentHistoryController extends Controller
{
    private $payment;
    public function __construct(PaymentServiceInterface $payment)
    {
        $this->payment = $payment;
    }
    public function show($status,$reference)
    {
        $response = $this->payment->show_payment_history(Crypt::decrypt($reference));
        return view('pages.transactions.payment-history',compact('response','reference','status'));
    }


}
