<?php

namespace App\Http\Controllers\Pages\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreAdministratorRequest;
use App\Interfaces\UserManagement\AdministratorServiceInterface;

class AdministratorController extends Controller
{
    private $administrator;
    public function __construct(AdministratorServiceInterface $administrator)
    {
        $this->administrator = $administrator;
    }

    public function index(Request $request)
    {
        $response = $this->administrator->get_administrator($request->all());
        return view('pages.user-management.administrator.index',compact('response'));
    }

    public function create()
    {
        return view('pages.user-management.administrator.create');
    }

    public function store(StoreAdministratorRequest $request)
    {
        $response = $this->administrator->create_administrator($request);
        return back()->with($response['status'],$response['message']);
    }


}
