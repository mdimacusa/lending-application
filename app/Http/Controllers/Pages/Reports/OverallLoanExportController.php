<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\OverallLoanServiceInterface;

class OverallLoanExportController extends Controller
{
    private $overall_loan;
    public function __construct(OverallLoanServiceInterface $overall_loan)
    {
        $this->overall_loan = $overall_loan;
    }

    public function export(Request $request)
    {
        return $this->overall_loan->export($request->all());
    }

}
