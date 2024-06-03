<?php

namespace App\Http\Controllers\Pages\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Transaction\StoreBorrowRequest;
use App\Interfaces\BorrowServiceInterface;
class BorrowController extends Controller
{
    private $borrow;
    public function __construct(BorrowServiceInterface $borrow)
    {
        $this->borrow = $borrow;
    }
    public function index()
    {
        $rates = $this->borrow->get_rates();
        return view('pages.transactions.borrow',compact('rates'));
    }

    public function store(StoreBorrowRequest $request)
    {
        $response = $this->borrow->borrow($request);
        return ($response['status']=="swal.success" ? redirect(route("borrow.index")) : back())->with($response['status'],$response['message']);
    }

    public function show($id)
    {
        $user = $this->borrow->get_client($id);
        return response()->json($user);
    }

}


