<?php

namespace App\Http\Controllers\Pages\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\UpdateAdministratorRequest;
use App\Interfaces\UserManagement\AdministratorServiceInterface;

class AdministratorProfileController extends Controller
{
    private $administrator;
    public function __construct(AdministratorServiceInterface $administrator)
    {
        $this->administrator = $administrator;
    }
    public function show(Request $request,$tab,$id)
    {
        $response = $this->administrator->show_profile($request->all(),$tab,$id);
        return view('pages.user-management.administrator.index-profile',compact('response'));
    }

    public function update(UpdateAdministratorRequest $request,$tab,$id)
    {
        $response = $this->administrator->update_administrator($request,$id);
        return redirect(route('administrator.profile',['tab'=>'summary','id'=>$id]))->with($response['status'],$response['message']);
    }
}
