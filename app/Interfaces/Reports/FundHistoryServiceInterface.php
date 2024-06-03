<?php

namespace App\Interfaces\Reports;

interface FundHistoryServiceInterface
{
    public function filters($request);

    public function get_fund_history($request);

    public function credit($request);

    public function debit($request);

    public function export($request);

}
