<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\FundHistoryServiceInterface;
use App\Models\User;
class FundHistoryController extends Controller
{
    private $fund_history;
    public function __construct(FundHistoryServiceInterface $fund_history)
    {
        $this->fund_history = $fund_history;
    }

    public function index(Request $request)
    {
        //dd(User::find(1)->company_wallet_history);
        $response = $this->fund_history->get_fund_history($request->all());
        return view('pages.report.fund-history',compact('response'));
    }

}
