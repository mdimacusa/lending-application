<?php

namespace App\Http\Controllers\Pages\Transactions\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentServiceInterface;
use Crypt;

class PaymentInvoiceController extends Controller
{
    private $payment;
    public function __construct(PaymentServiceInterface $payment)
    {
        $this->payment = $payment;
    }

    public function whole_transaction($reference)
    {
        $response = $this->payment->print_payment_account(Crypt::decrypt($reference));
        return view('pdf.invoice',compact('response'));
    }

    public function send_mail($reference)
    {
        $response = $this->payment->mail_attachment($reference);
        return back()->with($response['status'],$response['message']);
    }

    public function per_transaction($reference)
    {
        //
    }
}
