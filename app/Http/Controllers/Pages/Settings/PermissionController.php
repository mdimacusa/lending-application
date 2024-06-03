<?php

namespace App\Http\Controllers\Pages\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\StorePermission;
use App\Interfaces\Settings\RolesAndPermissionsServiceInterface;
class PermissionController extends Controller
{
    private $role_and_permission;
    public function __construct(RolesAndPermissionsServiceInterface $role_and_permission)
    {
        $this->role_and_permission = $role_and_permission;
    }

    public function create()
    {
        return view('pages.settings.roles-and-permissions.create-permission');
    }

    public function store(StorePermission $request)
    {
        $response = $this->role_and_permission->store_permission($request);
        return back()->with($response['status'],$response['message']);
    }
}
