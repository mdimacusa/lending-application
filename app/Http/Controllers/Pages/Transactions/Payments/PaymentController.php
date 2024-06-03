<?php

namespace App\Http\Controllers\Pages\Transactions\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentServiceInterface;
use App\Http\Requests\Transaction\StorePaymentRequest;
use Crypt;

class PaymentController extends Controller
{
    private $payment;
    public function __construct(PaymentServiceInterface $payment)
    {
        $this->payment = $payment;
    }

    public function show($status,$reference)
    {
        $response = $this->payment->show_payment(Crypt::decrypt($reference));
        return view('pages.transactions.payment',compact('response','status','reference'));
    }
    public function store(StorePaymentRequest $request,$status)
    {
        $response = $this->payment->payment($request->all(),Crypt::decrypt($request->reference));
        return (($response['payment_status']==2) ? redirect(route('payment.list',['status'=>$status])) : back())->with($response['status'],$response['message']);
    }

}
