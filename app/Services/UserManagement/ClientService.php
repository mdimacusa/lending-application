<?php

namespace App\Services\UserManagement;

use App\Models\Client;
use App\Models\Soa;
use DB;
use Crypt;
use App\Interfaces\UserManagement\ClientServiceInterface;

class ClientService implements ClientServiceInterface
{
    public function filters($request)
    {
        $filters=[
            "search"=>$request->search??"",
            "from"  =>$request->from??NULL,
            "to"    =>$request->to??NULL,
            "rows"  =>$request->rows??"10",
        ];
        return $filters;
    }

    public function get_client($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = Client::when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('unique_id','like','%'.$search.'%')
                ->orWhere('first_name','like','%'.$search.'%')
                ->orWhere('middle_name','like','%'.$search.'%')
                ->orWhere('surname','like','%'.$search.'%')
                ->orWhere('email','like','%'.$search.'%')
                ->orWhere('contact_number','like','%'.$search.'%');
            });
        })
        ->whereBetween('created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->when($rows=="All",function($query){
            return $query->get();
        },function($query)use($rows){
            return $query->paginate($rows ?? 10);
        });

        return ["query"=>$query,"filters"=>$filters];

    }

    public function create_client($request)
    {
        DB::beginTransaction();
        try {
            //Client::create($request);
            Client::insert([
                'unique_id'     => rand(11111111,99999999),
                'first_name'    => $request->first_name,
                'middle_name'   => $request->middle_name,
                'surname'       => $request->surname,
                'email'         => $request->email,
                'contact_number'=> $request->contact_number,
                'address'       => $request->address,
            ]);
            DB::commit();
            return ["status"=>"swal.success","message"=>"Successfully Client Added"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }
    public function update_client($request,$id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);
            Client::where('id',$id)->update($request);
            DB::commit();
            return ["status"=>"swal.success","message"=>"Successfully Client Updated"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }
    public function show_profile($request,$tab,$id)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $id      = Crypt::decrypt($id);
        $client  = Client::where('id',$id)->first();

        $query = Soa::where(['client_id'=>$id])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('disbursement_date','DESC')
        ->when($rows=="All",function($query){
            return $query->get();
        },function($query)use($rows){
            return $query->paginate($rows ?? 10);
        });

        $client_fully_paid      = $this->client_transactions($request,$id,2);
        $client_partially_paid  = $this->client_transactions($request,$id,1);
        $client_unpaid          = $this->client_transactions($request,$id,0);

        return [
            'client'=>$client,
            'query'=>$query,
            'tab'=>$tab,
            'filters'=>$filters,
            'client_fully_paid'=>$client_fully_paid,
            'client_partially_paid'=>$client_partially_paid,
            'client_unpaid'=>$client_unpaid,
        ];

    }

    public function client_transactions($request,$id,$status)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $client_fully_paid = Soa::where(['client_id'=>$id,'status'=>$status])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->sum('amount');

        return $client_fully_paid;
    }
}
