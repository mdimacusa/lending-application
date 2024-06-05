<?php

namespace App\Services\Settings;

use DB;
use Crypt;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Interfaces\Settings\RolesAndPermissionsServiceInterface;
class RolesAndPermissionsService implements RolesAndPermissionsServiceInterface
{
    public function get_roles()
    {
        $query  = Role::get();
        return  $query;
    }
    public function get_role($id)
    {
        $response = Role::where('id',$id)->first();
        return $response;
    }
    public function get_permission()
    {
        $permissions = Permission::select(DB::raw('DISTINCT module'))->get();
        foreach($permissions as $key => $module)
        {
            $permissions[$key]->permission = DB::table('permission')
            ->select('permission.*',DB::raw('0 as status'))
            ->where('module',$module->module)
            ->orderBy('permission.id','asc')
            ->get();
        }
        return  $permissions;
    }
    public function role_insert_get_id($request)
    {
        $response = Role::insertGetId(['title'=>$request->name]);
        return $response;
    }
    public function check_role_permission($id,$permission_id)
    {
        $response = RolePermission::where(["role_id" => $id,"permission_id" => $permission_id])->exists();
        return $response;
    }
    public function store_role($request)
    {
        DB::beginTransaction();
        try {
            $role_id          = $this->role_insert_get_id($request);
            $permissions_ids  = array_keys($request->permissions ?? []);
            $role             = $this->get_role($role_id);
            foreach($request->permissions ?? [] as $permission_id => $permission_status){
                $condition = $this->check_role_permission($role->id,$permission_id);
                if(!$condition)
                RolePermission::insert([
                    "role_id"        => $role->id,
                    "permission_id"  => $permission_id
                ]);
            }
            DB::commit();
            return ["status"=>"swal.success","message"=>"Role Created"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }
    public function store_permission($request)
    {
        DB::beginTransaction();
        try {
            Permission::insert([
                'name'   => $request->name,
                'module' => $request->module,
                'slug'   => $request->slug
            ]);
            DB::commit();
            return ["status"=>"swal.success","message"=>"Permission Created"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }
    public function get_distinct_permission()
    {
        $permissions  = Permission::select(DB::raw('DISTINCT module'))->get();
        return $permissions;
    }
    public function delete_role_permission($id,$permissions_ids)
    {
        $permissions  = RolePermission::where(["role_id" => $id])->whereNotIn('permission_id',$permissions_ids)->delete();
        return $permissions;
    }
    public function edt_role_and_permission($role_id)
    {
        $role_id      = Crypt::decrypt($role_id);
        $role         = $this->get_role($role_id);
        $permissions  = $this->get_distinct_permission();

        $permission   = Permission::select('permission.*',DB::raw('role_permission.id is not null as status'))
                        ->leftJoin('role_permission',function($join) use($role){
                        $join->on('role_permission.permission_id','=','permission.id')
                            ->where('role_permission.role_id',$role->id);
                        })
                        ->orderBy('permission.id','asc')
                        ->get()->toArray();

        //reorder permission , align in module data
        $reorder_data = array_reduce($permission, function($carry, $item) {
            $module = $item['module'];
            unset($item['module']);
            $carry[$module]['module'] = $module;
            $carry[$module]['permission'][] = (object)$item;
            return $carry;
        }, []);

        //change data to array keys
        $permissions = array_values($reorder_data);

        return ['permissions'=> $permissions,'role'=>$role];
    }
    public function update_role_and_permission($request,$role_id)
    {
        DB::beginTransaction();
        try {
            $permissions_ids    = array_keys($request->permissions ?? []);
            $role_id            = Crypt::decrypt($role_id);
            $role               = $this->get_role($role_id);

            $this->delete_role_permission($role->id,$permissions_ids);

            foreach($request->permissions ?? [] as $permission_id => $permission_status){

                $permission_query = Permission::where('id',$permission_id)->first();
                $condition = RolePermission::where(["role_id" => $role->id,"permission_id" => $permission_id])->exists();
                if(!$condition)
                RolePermission::insert([
                    "role_id"        => $role->id,
                    "permission_id"  => $permission_query->id
                ]);
            }

            DB::commit();
            return ["status"=>"swal.success","message"=>"Role Permissions Updated"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }

    }

}
