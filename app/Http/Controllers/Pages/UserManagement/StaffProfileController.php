<?php

namespace App\Http\Controllers\Pages\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\UpdateAdministratorRequest;
use App\Services\UserManagement\StaffService;

class StaffProfileController extends Controller
{
    private $staff;
    public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
    }
    public function show(Request $request,$tab,$id)
    {
        $response = $this->staff->show_profile($request->all(),$tab,$id);
        return view('pages.user-management.staff.index-profile',compact('response'));
    }

    public function update(UpdateAdministratorRequest $request,$tab,$id)
    {
        $response = $this->staff->update_staff($request,$id);
        return redirect(route('staff.profile',['tab'=>'summary','id'=>$id]))->with($response['status'],$response['message']);
    }
}
