<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\FundHistoryServiceInterface;

class FundHistoryExportController extends Controller
{
    private $fund_history;
    public function __construct(FundHistoryServiceInterface $fund_history)
    {
        $this->fund_history = $fund_history;
    }

    public function export(Request $request)
    {
        return $this->fund_history->export($request->all());
    }
}
