<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\TopBorrowerServiceInterface;

class TopBorrowerExportController extends Controller
{
    private $top_borrower;
    public function __construct(TopBorrowerServiceInterface $top_borrower)
    {
        $this->top_borrower = $top_borrower;
    }

    public function export(Request $request)
    {
        return $this->top_borrower->export($request->all());
    }
}
