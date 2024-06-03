<?php

namespace App\Services;

use DB;
use App\Models\PaymentAccount;
use App\Models\Payment;
use App\Models\CompanyWallet;
use App\Models\CompanyWalletHistory;
use App\Models\Notification;
use App\Interfaces\DepositFundServiceInterface;

class DepositFundService implements DepositFundServiceInterface
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
    public function get_deposit_fund($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = CompanyWalletHistory::select('company_wallet_history.*','users.name')
        ->join('users','users.id','=','company_wallet_history.user_id')
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('company_wallet_history.reference','like','%'.$search.'%')
                    ->orWhere('company_wallet_history.amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('company_wallet_history.created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->where('company_wallet_history.status','CREDIT')
        ->orderBy('company_wallet_history.created_at','DESC')
        ->when($rows=="All",function($query){
            return $query->get();
        },function($query)use($rows){
            return $query->paginate($rows ?? 10);
        });

        return ['query'=>$query,'filters'=> $filters];
    }
    public function get_company_wallet()
    {
        $query = CompanyWallet::get();
        return $query;
    }
    public function company_wallet_history($request)
    {
        $query = CompanyWalletHistory::insert([
            'user_id'  => auth()->user()->id,
            'reference' => $request['fund_reference'],
            'amount'    => $request['amount'],
        ]);
        return $query;
    }
    public function increment_company_wallet($initialize_data)
    {
        $query = CompanyWallet::increment('fund',$initialize_data['amount']);
        return $query;
    }
    public function added_company_notifications($initialize_data)
    {
        $query = Notification::insert([
            'user_id'    => auth()->user()->id,
            'name'       => auth()->user()->name,
            'reference'  => $initialize_data['fund_reference'],
            'category'   => 'Fund',
            'type'       => 'CREDIT',
            'amount'     => $initialize_data['amount'],
            'message'    => "The amount of ₱".number_format($initialize_data['amount'],2)." Has Been Successfully Added with REF# ".$initialize_data['fund_reference']." to the Company Fund",
        ]);

        return $query;
    }
    public function initialize_data($data)
    {
        $initialize_data = [
            'company_wallet'   => $this->get_company_wallet(),
            'amount'           => $data['amount'],
            'fund_reference'   => 'DEB'.rand(11111,99999).date('Y')
        ];

        return $initialize_data;
    }
    public function store_company_wallet($request)
    {
        DB::beginTransaction();
        try {
            $initialize_data = $this->initialize_data($request);

            extract($initialize_data);

            if($this->get_company_wallet()->count() > 0)
            $this->increment_company_wallet($initialize_data);
            else
            CompanyWallet::insert(['fund'=> $amount]);
            $this->company_wallet_history($initialize_data);
            $this->added_company_notifications($initialize_data);
            DB::commit();
            return ['status'=>'swal.success','message'=>'Successfully Deposit'];

        } catch(Throwable $exception) {
            DB::rollBack();
            return ['status'=>'swal.error','message'=>$exception->getMessage()];
        }
    }

}
