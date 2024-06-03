<?php

namespace App\Http\Controllers\Pages\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\StoreRole;
use App\Interfaces\Settings\RolesAndPermissionsServiceInterface;
class RoleController extends Controller
{
    private $role_and_permission;
    public function __construct(RolesAndPermissionsServiceInterface $role_and_permission)
    {
        $this->role_and_permission = $role_and_permission;
    }

    public function create()
    {
        $response  = $this->role_and_permission->get_permission();
        return view('pages.settings.roles-and-permissions.create-role',compact('response'));
    }

    public function store(StoreRole $request)
    {
        $response = $this->role_and_permission->store_role($request);
        return back()->with($response['status'],$response['message']);
    }
}
