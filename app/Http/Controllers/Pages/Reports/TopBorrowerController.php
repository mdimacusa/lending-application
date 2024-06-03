<?php

namespace App\Http\Controllers\Pages\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Reports\TopBorrowerServiceInterface;

class TopBorrowerController extends Controller
{
    private $top_borrower;
    public function __construct(TopBorrowerServiceInterface $top_borrower)
    {
        $this->top_borrower = $top_borrower;
    }
    public function index(Request $request)
    {
        $response = $this->top_borrower->get_top_borrower($request->all());
        return view('pages.report.top-borrower',compact('response'));
    }
}
