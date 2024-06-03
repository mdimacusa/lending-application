<?php

namespace App\Interfaces\UserManagement;

interface AdministratorServiceInterface
{
    public function filters($request);

    public function get_administrator($request);

    public function create_administrator($request);

    public function update_administrator($request,$id);

    public function show_profile($request,$tab,$id);

    public function administrator_transactions($request,$id,$status);

    public function total_deposit($request,$id);

}
