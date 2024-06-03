<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\CompanyIncomeServiceInterface;

class CompanyIncomeController extends Controller
{
    private $company_income;
    public function __construct(CompanyIncomeServiceInterface $company_income)
    {
        $this->company_income = $company_income;
    }
    public function index(Request $request)
    {
        $response = $this->company_income->get_company_income($request->all());
        return view('pages.report.company-income',compact('response'));
    }

}
