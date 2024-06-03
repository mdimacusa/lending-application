<?php

namespace App\Interfaces\Reports;

interface CompanyIncomeServiceInterface
{
    public function filters($request);

    public function get_company_income($request);

    public function export($request);

}
