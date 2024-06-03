<?php

namespace App\Interfaces;

interface PaymentServiceInterface
{
    public function filters($request);

    public function get_soa($request,$status);

    public function show_payment($reference);

    public function check_payment_transaction($reference);

    public function payment_remaining_mounth($reference);

    public function get_payment_account($reference);

    public function get_company_wallet();

    public function get_penalties_amount($init_data);

    public function initialize_data($request,$reference);

    public function insert_payment($init_data);

    public function update_soa($init_data);

    public function update_payment_account($init_data);

    public function paid_notifications($init_data);

    public function check_status($init_data);

    public function payment_company_wallet($init_data);

    public function company_wallet_history($init_data);

    public function increase_income($init_data);

    public function increase_penalties_amount($init_data);

    public function payment($request,$reference);

    public function show_payment_history($reference);

    public function print_payment_account($reference);

    public function download_agreement($soa_id,$reference);
}

