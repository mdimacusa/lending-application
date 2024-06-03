<?php

namespace App\Interfaces\UserManagement;

interface ClientServiceInterface
{
    public function filters($request);

    public function get_client($request);

    public function create_client($request);

    public function update_client($request,$id);

    public function show_profile($request,$tab,$id);

    public function client_transactions($request,$id,$status);

}
