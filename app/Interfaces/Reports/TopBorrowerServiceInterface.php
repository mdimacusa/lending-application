<?php

namespace App\Interfaces\Reports;

interface TopBorrowerServiceInterface
{
    public function filters($request);

    public function get_top_borrower($request);

    public function export($request);

}
