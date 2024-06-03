<?php

namespace App\Interfaces;

interface BorrowServiceInterface
{
    public function initialize_data($data,$pdf_file,$valid_id);

    public function get_rates();

    public function get_rate($rate);

    public function get_client($uniqueid);

    public function get_company_wallet();

    public function insert_soa($init_data);

    public function insert_payment_account($init_data);

    public function insert_company_wallet_history($init_data);

    public function upload_agreement($init_data,$soa_id);

    public function borrow_notifications($init_data);

    public function deducted_company_notifications($init_data);

    public function decrement_company_wallet($init_data);

    public function borrow($request);

}

