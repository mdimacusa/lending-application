<?php

namespace App\Services\Reports;

use App\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CompanyWalletHistory;
use App\Interfaces\Reports\FundHistoryServiceInterface;
use DB;
class FundHistoryService implements FundHistoryServiceInterface
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

    public function get_fund_history($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = CompanyWalletHistory::select('company_wallet_history.*','users.name')
        ->join('users','users.id','=','company_wallet_history.user_id')
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('company_wallet_history.reference','like','%'.$search.'%')
                ->orWhere('company_wallet_history.amount','like','%'.$search.'%')
                ->orWhere('users.name','like','%'.$search.'%');
            });
        })
        ->whereBetween('company_wallet_history.created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('company_wallet_history.created_at','DESC')
        ->when($rows=="All",function($query){
            return $query->get();
        },function($query)use($rows){
            return $query->paginate($rows ?? 10);
        });

        return ["query"=>$query,"filters"=>$filters];
    }

    public function credit($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $credit = CompanyWalletHistory::select('company_wallet_history.*','users.name')
        ->join('users','users.id','=','company_wallet_history.user_id')
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('company_wallet_history.reference','like','%'.$search.'%')
                ->orWhere('company_wallet_history.amount','like','%'.$search.'%')
                ->orWhere('users.name','like','%'.$search.'%');
            });
        })
        ->where('company_wallet_history.status','CREDIT')
        ->whereBetween('company_wallet_history.created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('company_wallet_history.created_at','DESC')
        ->limit($rows ?? 10)
        ->sum('company_wallet_history.amount');

        return $credit;
    }


    public function debit($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $debit = CompanyWalletHistory::select('company_wallet_history.*','users.name')
        ->join('users','users.id','=','company_wallet_history.user_id')
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('company_wallet_history.reference','like','%'.$search.'%')
                ->orWhere('company_wallet_history.amount','like','%'.$search.'%')
                ->orWhere('users.name','like','%'.$search.'%');
            });
        })
        ->where('company_wallet_history.status','DEBIT')
        ->whereBetween('company_wallet_history.created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('company_wallet_history.created_at','DESC')
        ->limit($rows ?? 10)
        ->sum('company_wallet_history.amount');

        return $debit;
    }

    public function export($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = CompanyWalletHistory::select('company_wallet_history.reference',
        DB::raw('CASE
            WHEN company_wallet_history.status = "DEBIT" THEN -company_wallet_history.amount
            ELSE +company_wallet_history.amount
        END AS amount'),'users.name','company_wallet_history.created_at')
        ->join('users','users.id','=','company_wallet_history.user_id')
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('company_wallet_history.reference','like','%'.$search.'%')
                ->orWhere('company_wallet_history.amount','like','%'.$search.'%')
                ->orWhere('users.name','like','%'.$search.'%');
            });
        })
        ->whereBetween('company_wallet_history.created_at',[($filters['from'] ?? "0000-00-00")." 00:00:00",($filters['to'] ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('company_wallet_history.created_at','DESC')
        ->when($rows=="All",function($query){
            return $query->get()->toArray();
        },function($query)use($rows){
            return $query->limit($rows ?? 10)->get()->toArray();
        });

        $credit = $this->credit($request);
        $debit  = $this->debit($request);

        $new_row = (object)[
            'Reference'       => 'Total Credit Amount',
            'Amount(₱)'       => '₱'.number_format($credit,2),
            'Processed By'    => 'Total Debit Amount',
            'Processed Date'  => '₱'.number_format($debit,2),
        ];
        $query[]      = $new_row;
        $excel_data   = [];
        $excel_header = ['Reference','Amount(₱)','Processed By','Processed Date'];
        $excel_data=array_merge($excel_data,$query);
        return Excel::download(new ExportExcel($excel_header,$excel_data), 'fund-history-'.date('Y-m-d').'.xlsx');
    }

}
