<?php

namespace App\Http\Controllers\Pages\Transactions\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentServiceInterface;

class PaymentSOAController extends Controller
{
    private $payment;
    public function __construct(PaymentServiceInterface $payment)
    {
        $this->payment = $payment;
    }
    public function show(Request $request,$status)
    {
        $response = $this->payment->get_soa($request->all(),$status);
        return view('pages.transactions.soa',compact('response'));
    }
}
