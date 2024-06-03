<?php

namespace App\Http\Controllers\Pages\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Transaction\StoreDepositRequest;
use App\Interfaces\DepositFundServiceInterface;
class DepositController extends Controller
{
    private $fund;
    public function __construct(DepositFundServiceInterface $fund)
    {
        $this->fund = $fund;
    }

    public function create()
    {
        return view('pages.transactions.deposit');
    }

    public function store(StoreDepositRequest $request)
    {
        $response = $this->fund->store_company_wallet($request->all());
        return ($response['status']=="swal.success" ? redirect(route("deposit.create")) : back())->with($response['status'],$response['message']);
    }
}
