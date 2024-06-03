<?php

namespace App\Http\Controllers\Pages\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\UpdateClientRequest;
use App\Interfaces\UserManagement\ClientServiceInterface;

class ClientProfileController extends Controller
{
    private $client;
    public function __construct(ClientServiceInterface $client)
    {
        $this->client = $client;
    }

    public function show(Request $request,$tab,$id)
    {
        $response = $this->client->show_profile($request->all(),$tab,$id);
        return view('pages.user-management.index-profile',compact('response'));
    }

    public function update(UpdateClientRequest $request,$tab,$id)
    {
        $response = $this->client->update_client($request->validated(),$id);
        return redirect(route('client.profile',['tab'=>'summary','id'=>$id]))->with($response['status'],$response['message']);
    }

}
