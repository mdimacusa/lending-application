<?php

namespace App\Http\Controllers\Pages\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreClientRequest;
use App\Interfaces\UserManagement\ClientServiceInterface;

class ClientController extends Controller
{
    private $client;
    public function __construct(ClientServiceInterface $client)
    {
        $this->client = $client;
    }
    public function index(Request $request)
    {
        $response = $this->client->get_client($request->all());
        return view('pages.user-management.client',compact('response'));
    }

    public function create()
    {
        return view('pages.user-management.create');
    }

    public function store(StoreClientRequest $request)
    {
        $response = $this->client->create_client($request);
        return back()->with($response['status'],$response['message']);
    }
}
