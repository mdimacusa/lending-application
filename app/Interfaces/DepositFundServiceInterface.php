<?php

namespace App\Interfaces;

interface DepositFundServiceInterface
{
    public function filters($request);

    public function get_deposit_fund($request);

    public function get_company_wallet();

    public function company_wallet_history($request);

    public function increment_company_wallet($initialize_data);

    public function added_company_notifications($initialize_data);

    public function initialize_data($data);

    public function store_company_wallet($request);

}

