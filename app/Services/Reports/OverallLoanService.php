<?php

namespace App\Services\Reports;

use App\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PaymentAccount;
use App\Interfaces\Reports\OverallLoanServiceInterface;

class OverallLoanService implements OverallLoanServiceInterface
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

    public function get_overall_loan($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = PaymentAccount::where('status',2)
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('interest','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('disbursement_date','DESC')
        ->when($rows=="All",function($query){
            return $query->get();
        },function($query)use($rows){
            return $query->paginate($rows ?? 10);
        });

        return ["query"=>$query,"filters"=>$filters];
    }

    public function export($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query = PaymentAccount::where('status',2)
        ->select('reference','income','disbursement_date')
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('interest','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('disbursement_date','DESC')
        ->when($rows=="All",function($query){
            return $query->get()->toArray();
        },function($query)use($rows){
            return $query->limit($rows ?? 10)->get()->toArray();
        });

        $total_amount = 0;
        foreach($query as $sum){
            $total_amount += $sum['income'];
        }
        $new_row = (object)[
            'Reference' => 'Total Amount',
            'Amount(₱)' => '₱'.number_format($total_amount,2),
            'Date'      => '',
        ];
        $query[]      = $new_row;
        $excel_data   = [];
        $excel_header = ['Reference','Amount(₱)','Date'];
        $excel_data=array_merge($excel_data,$query);
        return Excel::download(new ExportExcel($excel_header,$excel_data), 'company-income-'.date('Y-m-d').'.xlsx');
    }

}
