<?php

namespace App\Http\Controllers\Pages\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\StorePermissions;
use DB;
use Crypt;
use App\Interfaces\Settings\RolesAndPermissionsServiceInterface;
class RolesAndPermissionsController extends Controller
{
    private $role_and_permission;
    public function __construct(RolesAndPermissionsServiceInterface $role_and_permission)
    {
        $this->role_and_permission = $role_and_permission;
    }

    public function index()
    {
        $response  = $this->role_and_permission->get_roles();
        return view('pages.settings.roles-and-permissions.index',compact('response'));
    }
    public function edit($id)
    {
        $response  = $this->role_and_permission->edt_role_and_permission($id);
        return view('pages.settings.roles-and-permissions.edit-permissions',compact('response','id'));
    }
    public function update(Request $request,$id)
    {
        $response  = $this->role_and_permission->update_role_and_permission($request,$id);
        return redirect(route('roles-and-permissions.edit',['roles_and_permission'=>$id]))->with($response['status'],$response['message']);
    }
}
