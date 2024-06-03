<?php

namespace App\Services\Reports;

use App\Exports\ExportExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Soa;
use App\Interfaces\Reports\TopBorrowerServiceInterface;
use DB;
class TopBorrowerService implements TopBorrowerServiceInterface
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

    public function get_top_borrower($request)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $query =  Soa::select('client.unique_id','soa.fullname',DB::raw('COALESCE(SUM(soa.amount),0) as borrowed_amount'))
        ->leftJoin('client',function($join){
            $join->on('soa.client_id','=','client.id');
        })
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('client.unique_id','like','%'.$search.'%')
                ->orWhere('soa.fullname','like','%'.$search.'%');
            });
        })
        ->whereBetween('created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->groupBy('client.unique_id','soa.fullname')
        ->orderByDesc('borrowed_amount')
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

        $query =  Soa::select('client.unique_id','soa.fullname',DB::raw('COALESCE(SUM(soa.amount),0) as borrowed_amount'))
        ->leftJoin('client',function($join){
            $join->on('soa.client_id','=','client.id');
        })
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('client.unique_id','like','%'.$search.'%')
                ->orWhere('soa.fullname','like','%'.$search.'%');
            });
        })
        ->whereBetween('created_at',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->groupBy('client.unique_id','soa.fullname')
        ->orderByDesc('borrowed_amount')
        ->when($rows=="All",function($query){
            return $query->get()->toArray();
        },function($query)use($rows){
            return $query->limit($rows ?? 10)->get()->toArray();
        });

        $excel_data   = [];
        $excel_header = ['Client Unique ID','Fullname','Total Amount(₱)'];
        $excel_data=array_merge($excel_data,$query);
        return Excel::download(new ExportExcel($excel_header,$excel_data), 'top-borrower-'.date('Y-m-d').'.xlsx');
    }
}
