<?php

namespace App\Interfaces\Settings;

interface RolesAndPermissionsServiceInterface
{
    public function get_roles();

    public function get_role($id);

    public function get_permission();

    public function role_insert_get_id($request);

    public function check_role_permission($id,$permission_id);

    public function store_role($request);

    public function store_permission($request);

    public function get_distinct_permission();

    public function delete_role_permission($id,$permissions_ids);

    public function edt_role_and_permission($role_id);

    public function update_role_and_permission($request,$role_id);

}

