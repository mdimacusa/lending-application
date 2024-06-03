<?php

namespace App\Services\UserManagement;

use App\Models\User;
use App\Models\Soa;
use App\Models\CompanyWalletHistory;
use DB;
use Crypt;
use Hash;
use App\Interfaces\UserManagement\AdministratorServiceInterface;

class AdministratorService implements AdministratorServiceInterface
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

    public function get_administrator($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = User::where('role',"ADMINISTRATOR")
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('unique_id','like','%'.$search.'%')
                ->orWhere('name','like','%'.$search.'%')
                ->orWhere('email','like','%'.$search.'%');
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

    public function create_administrator($request)
    {
        DB::beginTransaction();
        try {
            User::insert([
                'unique_id' => rand(11111111,99999999),
                'name'      => $request->first_name.' '.$request->middle_name.' '.$request->surname,
                'email'     => $request->email,
                'pincode'   => $request->pincode,
                'password'  => Hash::make($request->password),
                'role'      => "ADMINISTRATOR",

            ]);
            DB::commit();
            return ["status"=>"swal.success","message"=>"Successfully Administrator Added"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }

    public function update_administrator($request,$id)
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($id);

            $user = User::find($id);
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->email    = $request->email;
            $user->pincode  = $request->pincode;
            $user->status   = $request->status;
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            return ["status"=>"swal.success","message"=>"Successfully Administrator Updated"];
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

        $id = Crypt::decrypt($id);
        $administrator = User::where('id',$id)->first();

        $class = ($tab=="transaction")?Soa::class:CompanyWalletHistory::class;
        $class_column = ($tab=="transaction")?'disbursement_date':'created_at';

        $query = $class::where(['user_id'=>$id])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->when($rows=="All",function($query){
            return $query->whereBetween($class_column,[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
                    ->orderBy($class_column,'DESC')
                    ->get();
        },function($query)use($class_column){
            return $query->whereBetween($class_column,[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
                ->orderBy($class_column,'DESC')
                ->paginate($rows ?? 10);
        });

        $administrator_fully_paid     = $this->administrator_transactions($request,$id,2);
        $administrator_partially_paid = $this->administrator_transactions($request,$id,1);
        $administrator_unpaid         = $this->administrator_transactions($request,$id,0);
        $total_deposit                = $this->total_deposit($request,$id);

        return [
            'administrator'=>$administrator,
            'query'=>$query,
            'tab'=>$tab,
            'filters'=>$filters,
            'administrator_fully_paid'=>$administrator_fully_paid,
            'administrator_partially_paid'=>$administrator_partially_paid,
            'administrator_unpaid'=>$administrator_unpaid,
            'total_deposit'=>$total_deposit,
        ];

    }

    public function administrator_transactions($request,$id,$status)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $administrator_transactions = Soa::where(['user_id'=>$id,'status'=>$status])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->sum('amount');

        return $administrator_transactions;
    }
    public function total_deposit($request,$id)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $total_deposit = CompanyWalletHistory::where(['user_id'=>$id,'status'=>'CREDIT'])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->sum('amount');

        return $total_deposit;
    }
}

