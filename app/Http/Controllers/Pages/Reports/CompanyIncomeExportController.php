<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\CompanyIncomeServiceInterface;

class CompanyIncomeExportController extends Controller
{
    private $company_income;
    public function __construct(CompanyIncomeServiceInterface $company_income)
    {
        $this->company_income = $company_income;
    }

    public function export(Request $request)
    {
        return $this->company_income->export($request->all());
    }

}
