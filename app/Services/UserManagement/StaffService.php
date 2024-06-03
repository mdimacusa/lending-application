<?php

namespace App\Services\UserManagement;

use App\Models\User;
use App\Models\Soa;
use App\Models\CompanyWalletHistory;
use DB;
use Crypt;
use Hash;

class StaffService
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

    public function get_staff($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = User::where('role',"STAFF")
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

    public function create_staff($request)
    {
        DB::beginTransaction();
        try {
            User::insert([
                'unique_id' => rand(11111111,99999999),
                'name'      => $request->first_name.' '.$request->middle_name.' '.$request->surname,
                'email'     => $request->email,
                'pincode'   => $request->pincode,
                'password'  => Hash::make($request->password),
                'role'      => "STAFF",

            ]);
            DB::commit();
            return ["status"=>"swal.success","message"=>"Successfully Staff Added"];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }

    public function update_staff($request,$id)
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
            return ["status"=>"swal.success","message"=>"Successfully Staff Updated"];
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
        $staff = User::where('id',$id)->first();

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

        $staff_fully_paid     = $this->staff_transactions($request,$id,2);
        $staff_partially_paid = $this->staff_transactions($request,$id,1);
        $staff_unpaid         = $this->staff_transactions($request,$id,0);
        $total_deposit        = $this->total_deposit($request,$id);

        return [
            'staff'=>$staff,
            'query'=>$query,
            'tab'=>$tab,
            'filters'=>$filters,
            'staff_fully_paid'=>$staff_fully_paid,
            'staff_partially_paid'=>$staff_partially_paid,
            'staff_unpaid'=>$staff_unpaid,
            'total_deposit'=>$total_deposit,
        ];

    }

    public function staff_transactions($request,$id,$status)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $staff_transactions = Soa::where(['user_id'=>$id,'status'=>$status])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->sum('amount');

        return $staff_transactions;
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

