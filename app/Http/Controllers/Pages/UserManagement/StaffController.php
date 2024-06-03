<?php

namespace App\Http\Controllers\Pages\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreAdministratorRequest;
use App\Services\UserManagement\StaffService;

class StaffController extends Controller
{
    private $staff;
    public function __construct(StaffService $staff)
    {
        $this->staff = $staff;
    }

    public function index(Request $request)
    {
        $response = $this->staff->get_staff($request->all());
        return view('pages.user-management.staff.index',compact('response'));
    }

    public function create()
    {
        return view('pages.user-management.staff.create');
    }

    public function store(StoreAdministratorRequest $request)
    {
        $response = $this->staff->create_staff($request);
        return back()->with($response['status'],$response['message']);
    }


}
