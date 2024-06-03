<?php

namespace App\Http\Controllers\Pages\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\DepositFundServiceInterface;
class FundController extends Controller
{
    private $fund;
    public function __construct(DepositFundServiceInterface $fund)
    {
        $this->fund = $fund;
    }

    public function index(Request $request)
    {
        $response = $this->fund->get_deposit_fund($request->all());

        return view('pages.transactions.fund',compact('response'));
    }
}
