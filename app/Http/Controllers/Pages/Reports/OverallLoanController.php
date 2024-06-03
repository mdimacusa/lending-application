<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\OverallLoanServiceInterface;

class OverallLoanController extends Controller
{
    private $overall_loan;
    public function __construct(OverallLoanServiceInterface $overall_loan)
    {
        $this->overall_loan = $overall_loan;
    }
    public function index(Request $request)
    {
        $response = $this->overall_loan->get_overall_loan($request->all());
        return view('pages.report.overall-loan',compact('response'));
    }
}
