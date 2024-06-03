<?php

namespace App\Interfaces\Reports;

interface OverallLoanServiceInterface
{
    public function filters($request);

    public function get_overall_loan($request);

    public function export($request);

}
