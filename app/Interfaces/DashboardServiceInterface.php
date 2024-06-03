<?php

namespace App\Interfaces;

interface DashboardServiceInterface
{
    public function initialize_data();

    public function get_data();

    public function get_today_transaction($currentdate);

    public function get_overall_transaction();

    public function get_today_income($currentdate);

    public function get_overall_income();

    public function get_total_fund();

    public function get_overall_used_fund();

    public function get_total_unpaid();

    public function get_total_partially_paid();

    public function get_total_paid();

    public function get_borrow_notif_credit();

    public function get_fund_notift();

    public function get_notification_count();

    public function get_unpaid();

    public function get_partially_paid();

    public function get_fully_paid();

    public function get_clients();

    public function get_administrator();

}

