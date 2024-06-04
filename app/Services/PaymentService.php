<?php

namespace App\Services;

use DB;
use Crypt;
use Madzipper;
use Carbon\Carbon;
use App\Models\Soa;
use App\Models\PaymentAccount;
use App\Models\Payment;
use App\Models\CompanyWallet;
use App\Models\CompanyWalletHistory;
use App\Models\Notification;
use App\Models\Agreement;
use Illuminate\Support\Facades\Storage;
use PDF;
use Mail;
use App\Mail\NotificationMail;
use App\Interfaces\PaymentServiceInterface;
class PaymentService implements PaymentServiceInterface
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
    public function get_soa($request,$status)
    {
        $request = (object)$request;

        $filters = $this->filters($request);
        extract($filters);

        $data = Soa::with(['client','user'])
        ->when(!empty($search),function($query)use($search){
            $query->where(function($query) use($search){
                $query->orWhere('reference','like','%'.$search.'%')
                ->orWhere('amount','like','%'.$search.'%');
            });
        })
        ->whereBetween('disbursement_date',[($from ?? "0000-00-00")." 00:00:00",($to ?? date("Y-m-d"))." 23:59:59"])
        ->orderBy('disbursement_date','DESC')
        ->when($rows=="All",function($query)use($status){
            $query->when($status=="fully-paid", function ($query) {
                $query->where('status',2);
            })
            ->when($status=="partially-paid", function ($query) {
                $query->where('status',1);
            })
            ->when($status=="unpaid", function ($query) {
                $query->where('status',0);
            });
            return $query->get();
        },function($query)use($rows,$status){
            $query->when($status=="fully-paid", function ($query) {
                $query->where('status',2);
            })
            ->when($status=="partially-paid", function ($query) {
                $query->where('status',1);
            })
            ->when($status=="unpaid", function ($query) {
                $query->where('status',0);
            });
            return $query->paginate($rows ?? 10);
        });

        return ["query"=>$data,"filters"=>$filters,"status"=>$status];
    }
    public function show_payment($reference)
    {
        $query = PaymentAccount::with(['client'])->where('reference',$reference)->first();
        $to    = Carbon::parse(date('Y-m-d',strtotime($query->upcoming_due_date)));
        $from  = Carbon::parse(date("Y-m-d",strtotime($query->due_date)));
        $count_month = $to->diffInMonths($from)+1;
        $remaining_month = ($this->check_payment_transaction($reference))?abs($this->payment_remaining_mounth($reference)-$query->tenurity):$query->tenurity;
        $data = [
            'query'             =>  $query,
            'count_month'       =>  $count_month,
            'remaining_month'   =>  $remaining_month,
        ];
        return $data;
    }
    public function check_payment_transaction($reference)
    {
        $data = Payment::where(['reference' => $reference])->exists();
        return $data;
    }
    public function payment_remaining_mounth($reference)
    {
        $data = Payment::where(['reference' => $reference])->count();
        return $data;
    }
    public function get_payment_account($reference)
    {
        $query = PaymentAccount::where('reference',$reference)->first();
        return $query;
    }
    public function get_company_wallet()
    {
        $query = CompanyWallet::get();
        return $query;
    }
    public function get_penalties_amount($init_data)
    {
        extract($init_data);
        $query = PaymentAccount::where(['account_no' => $data->account_no])->first()->additional_interest_amount;
        return $query;
    }
    public function initialize_data($request,$reference)
    {
        $data = (object)$request;

        switch($data->payment_method) {

            case('Standard Payment'):
                $init_data = [
                    'payment_method'    => $data->payment_method,
                    'processed_by'      => auth()->user()->id,
                    'data'              => $this->get_payment_account($reference),
                    'remarks'           => $data->remarks,
                    'payment_date'      => $data->payment_date,
                    'payment_for'       => $data->payment_for,
                    'fund_reference'    => $reference,
                    'company_wallet'    => $this->get_company_wallet(),
                ];

                extract($init_data);

                $init_data['remaining_month']   = ($this->check_payment_transaction($reference))?abs($this->payment_remaining_mounth($reference)-(int)$data->tenurity)-1:(int)$data->tenurity-1;
                $init_data['amount']            = ($init_data['remaining_month']==0)?$data->loan_outstanding:$data->monthly * $payment_for;
                $init_data['payment_amount']    = round(($data->monthly * $payment_for)-($data->interest / $data->tenurity) * $payment_for,2);
                $init_data['monthly']           = round($data->monthly,2);
                $init_data['loan_outstanding']  = (($data->loan_outstanding - $init_data['amount']) < 3) ? 0 : $data->loan_outstanding - $init_data['amount'];
                $init_data['upcoming_due_date'] = (new Carbon(date('Y-m-d',strtotime($data->upcoming_due_date))))->addMonths($payment_for);
                $init_data['to']                = Carbon::parse(date($init_data['upcoming_due_date']))->subMonths(1);
                $init_data['from']              = Carbon::parse(date("Y-m-d",strtotime($data->due_date)));
                $init_data['count_month']       = $init_data['to']->diffInMonths($init_data['from']);
                $init_data['new_monthly']       = ($init_data['to']->diffInMonths($init_data['from'])>0) ? $init_data['loan_outstanding'] / $init_data['count_month'] : 0.0;
            break;

            case('Interest'):
                $init_data = [
                    'payment_method'    => $data->payment_method,
                    'processed_by'      => auth()->user()->id,
                    'data'              => $this->get_payment_account($reference),
                    'remarks'           => $data->remarks,
                    'payment_date'      => $data->payment_date,
                    'payment_for'       => 1,
                ];

                extract($init_data);

                $init_data['remaining_month']       = ($this->check_payment_transaction($reference))?abs($this->payment_remaining_mounth($reference)-(int)$data->tenurity)-1:(int)$data->tenurity-1;
                $init_data['amount']                = round(($this->get_penalties_amount($init_data)>0)?(($data->monthly*$data->rate)+$this->get_penalties_amount($init_data)):$data->monthly*$data->rate,2);
                $init_data['monthly']               = round($data->monthly,2);
                $init_data['rate']                  = $data->rate;
                $init_data['penalty_interest']      = round($data->monthly*$data->rate,2);
                $init_data['total_payment']         = $init_data['amount'];
                $init_data['loan_outstanding']      = round($data->loan_outstanding,2);
                $init_data['upcoming_due_date']     = (new Carbon(date('Y-m-d',strtotime($data->upcoming_due_date))))->addMonths($payment_for);
            break;
            default:
            $init_data = [
                'payment_method'    => $data->payment_method,
                'processed_by'      => auth()->user()->id,
                'data'              => $this->get_payment_account($reference),
                'remarks'           => $data->remarks,
                'payment_date'      => $data->payment_date,
                'fund_reference'    => $reference,
                'company_wallet'    => $this->get_company_wallet(),
            ];

            extract($init_data);
            $init_data['payment_for']           = ($this->check_payment_transaction($reference))?abs($this->payment_remaining_mounth($reference)-$data->tenurity):$data->tenurity;
            $init_data['remaining_month']       = $init_data['payment_for'];
            $init_data['amount']                = round($data->loan_outstanding,2);
            $init_data['payment_amount']        = round(($data->monthly * $init_data['payment_for'])-($data->interest / $data->tenurity) * $init_data['payment_for'],2);
            $init_data['monthly']               = round($data->monthly,2);
            $init_data['rate']                  = $data->rate;
            $init_data['penalty_interest']      = 0;
            $init_data['total_payment']         = $init_data['amount'];
            $init_data['loan_outstanding']      = 0;
            $init_data['upcoming_due_date']     = (new Carbon(date('Y-m-d',strtotime($data->upcoming_due_date))))->addMonths($init_data['payment_for']);
        }

        return $init_data;
    }
    public function insert_payment($init_data)
    {
        extract($init_data);

        if($payment_method=="Standard Payment")
        {
            $query = Payment::insert([
                'client_id'         => $data->client_id,
                'user_id'          => $processed_by,
                'fullname'          => $data->fullname,
                'rate'              => $data->rate,
                'amount'            => $data->amount,
                'tenurity'          => $data->tenurity,
                'interest'          => $loan_outstanding=="0.0"?"0.0":$data->interest,
                'loan_outstanding'  => round($loan_outstanding,2),
                'monthly'           => round($loan_outstanding=="0.0"?"0.0":$monthly,2),
                'reference'         => $data->reference,
                'status'            => $loan_outstanding=="0.0"?"2":"1",
                'remarks'           => $remarks,
                'payment_amount'    => $amount,
                'payment_for'       => $loan_outstanding=="0.0"?"Completed":$payment_for,
                'payment_method'    => $payment_method,
                'disbursement_date' => $data->disbursement_date,
                'last_payment_date' => $payment_date,
                'upcoming_due_date' => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
                'due_date'          => $data->due_date,
            ]);
        }
        else
        {

            $query = Payment::insert([
                'client_id'         => $data->client_id,
                'user_id'          => $processed_by,
                'fullname'          => $data->fullname,
                'rate'              => $data->rate,
                'amount'            => $data->amount,
                'tenurity'          => $data->tenurity,
                'interest'          => $loan_outstanding=="0.0"?"0.0":$data->interest,
                'loan_outstanding'  => round($loan_outstanding,2),
                'monthly'           => round($loan_outstanding=="0.0"?"0.0":$monthly,2),
                'reference'         => $data->reference,
                'status'            => $loan_outstanding=="0.0"?"2":"1",
                'remarks'           => $remarks,
                'payment_amount'    => round($total_payment,2),
                'balance_amount'    => 0,
                'penalty_interest'  => round($penalty_interest,2),
                'payment_for'       => $loan_outstanding=="0.0"?"Completed":$payment_for,
                'payment_method'    => $payment_method,
                'disbursement_date' => $data->disbursement_date,
                'last_payment_date' => $payment_date,
                'upcoming_due_date' => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
                'due_date'          => $data->due_date,
            ]);
        }

        return $query;
    }
    public function update_soa($init_data)
    {
        extract($init_data);

        if($payment_method=="Standard Payment")
        {
            $query = Soa::where('reference',$data->reference)
            ->update([
                'user_id'                  => $processed_by,
                'status'                   => $loan_outstanding=="0.0"?"2":"1",
                'remarks'                  => $remarks,
                'payment_amount'           => $amount,
                'payment_method'           => $payment_method,
                'last_payment_date'        => $payment_date,
                'current_loan_outstanding' => $loan_outstanding,
                'upcoming_due_date'        => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
            ]);
        }
        else
        {
            $query = Soa::where('reference',$data->reference)
            ->update([
                'user_id'                   => $processed_by,
                'status'                    => $loan_outstanding=="0.0"?"2":"1",
                'remarks'                   => $remarks,
                'payment_amount'            => round($total_payment,2),
                'payment_method'            => $payment_method,
                'monthly'                   => round($loan_outstanding=="0.0"?"0.0":$monthly,2),
                'current_loan_outstanding'  => $loan_outstanding,
                'last_payment_date'         => $payment_date,
                'upcoming_due_date'         => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
            ]);
        }

        return $query;
    }
    public function update_payment_account($init_data)
    {
        extract($init_data);

        switch($payment_method) {
            case('Standard Payment'):
                $query = PaymentAccount::where('account_no',$data->account_no)
                ->update([
                    'client_id'                 => $data->client_id,
                    'user_id'                  => $processed_by,
                    'fullname'                  => $data->fullname,
                    'rate'                      => $data->rate,
                    'amount'                    => $data->amount,
                    'tenurity'                  => $data->tenurity,
                    'interest'                  => $loan_outstanding=="0.0"?"0.0":$data->interest,
                    'loan_outstanding'          => round($loan_outstanding,2),
                    'monthly'                   => round($loan_outstanding=="0.0"?"0.0":$monthly,2),
                    'reference'                 => $data->reference,
                    'status'                    => $loan_outstanding=="0.0"?"2":"1",
                    'remarks'                   => $remarks,
                    'payment_amount'            => $amount,
                    'additional_interest_amount'=> 0.0,
                    'payment_for'               => $loan_outstanding=="0.0"?"Completed":"1",
                    'payment_method'            => $payment_method,
                    'disbursement_date'         => $data->disbursement_date,
                    'last_payment_date'         => $payment_date,
                    'upcoming_due_date'         => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
                    'due_date'                  => $data->due_date,
                ]);
            break;
            case('Interest'):
                $query = PaymentAccount::where('account_no',$data->account_no)
                ->update([
                    'client_id'                 => $data->client_id,
                    'user_id'                  => $processed_by,
                    'fullname'                  => $data->fullname,
                    'rate'                      => $data->rate,
                    'amount'                    => $data->amount,
                    'tenurity'                  => $data->tenurity,
                    'interest'                  => $loan_outstanding=="0.0"?"0.0":$data->interest,
                    'loan_outstanding'          => round($loan_outstanding,2),
                    'monthly'                   => round($loan_outstanding=="0.0"?"0.0":$monthly,2),
                    'reference'                 => $data->reference,
                    'status'                    => $loan_outstanding=="0.0"?"2":"1",
                    'remarks'                   => $remarks,
                    'payment_amount'            => round($total_payment,2),
                    'balance_amount'            => 0,
                    'penalty_interest'          => round($penalty_interest,2),
                    'payment_for'               => $loan_outstanding=="0.0"?"Completed":$payment_for,
                    'payment_method'            => $payment_method,
                    'disbursement_date'         => $data->disbursement_date,
                    'last_payment_date'         => $payment_date,
                    'upcoming_due_date'         => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
                    'due_date'                  => $data->due_date,
                ]);
            break;
            default:
                $query = PaymentAccount::where('account_no',$data->account_no)
                ->update([
                    'client_id'                 => $data->client_id,
                    'user_id'                  => $processed_by,
                    'fullname'                  => $data->fullname,
                    'rate'                      => $data->rate,
                    'amount'                    => $data->amount,
                    'tenurity'                  => $data->tenurity,
                    'interest'                  => $loan_outstanding=="0.0"?"0.0":$data->interest,
                    'loan_outstanding'          => round($loan_outstanding,2),
                    'monthly'                   => round($loan_outstanding=="0.0"?"0.0":$monthly,2),
                    'reference'                 => $data->reference,
                    'status'                    => $loan_outstanding=="0.0"?"2":"1",
                    'remarks'                   => $remarks,
                    'payment_amount'            => round($total_payment,2),
                    'balance_amount'            => 0,
                    'penalty_interest'          => round($penalty_interest,2),
                    'payment_for'               => $loan_outstanding=="0.0"?"Completed":$payment_for,
                    'payment_method'            => $payment_method,
                    'disbursement_date'         => $data->disbursement_date,
                    'last_payment_date'         => $payment_date,
                    'upcoming_due_date'         => $loan_outstanding=="0.0"?NULL:$upcoming_due_date,
                    'due_date'                  => $data->due_date,
                ]);
        }

        return $query;
    }
    public function paid_notifications($init_data)
    {
        extract($init_data);

        if($payment_method=="Standard Payment")
        {
            $query = Notification::insert([
                'client_id'  => $data->client_id,
                'user_id'   => $processed_by,
                'name'       => $data->fullname,
                'reference'  => $data->reference,
                'category'   => 'Borrow',
                'type'       => 'CREDIT',
                'amount'     => $amount,
                'message'    => "The amount of ₱".number_format($amount,2)." with REF# ".$data->reference." Has Been Successfully Paid",
            ]);
        }
        else
        {
            $query = Notification::insert([
                'client_id'  => $data->client_id,
                'user_id'   => $processed_by,
                'name'       => $data->fullname,
                'reference'  => $data->reference,
                'category'   => 'Borrow',
                'type'       => 'CREDIT',
                'amount'     => round($total_payment,2),
                'message'    => "The amount of ₱".number_format(round($total_payment,2),2)." with REF# ".$data->reference." Has Been Successfully Paid",
            ]);
        }

        return $query;
    }
    public function check_status($init_data)
    {
        extract($init_data);
        $query = PaymentAccount::where('account_no',$data->account_no)->first();
        return $query;
    }
    public function payment_company_wallet($init_data)
    {
        $query = CompanyWallet::increment('fund',$init_data['payment_amount']);
        return $query;
    }
    public function company_wallet_history($init_data)
    {
        $query = CompanyWalletHistory::insert([
            'user_id'  => auth()->user()->id,
            'reference' => $init_data['fund_reference'],
            'amount'    => $init_data['payment_amount'],
        ]);
        return $query;
    }
    public function increase_income($init_data)
    {
        extract($init_data);
        $query = PaymentAccount::where(['account_no' => $data->account_no])->increment('income',$penalty_interest);
        return $query;
    }
    public function increase_penalties_amount($init_data)
    {
        extract($init_data);
        $query = PaymentAccount::where(['account_no' => $data->account_no])->increment('additional_interest_amount',$penalty_interest);
        return $query;
    }
    public function payment($request,$reference)
    {
        DB::beginTransaction();
        try {
            $initialize_data = $this->initialize_data($request,$reference);

            extract($initialize_data);

            $this->insert_payment($initialize_data);
            $this->update_soa($initialize_data);
            $this->update_payment_account($initialize_data);
            $this->paid_notifications($initialize_data);

            switch($request['payment_method']) {
                case('Standard Payment'):
                    $this->payment_company_wallet($initialize_data);
                    $this->company_wallet_history($initialize_data);
                break;
                case('Interest'):
                    $this->increase_penalties_amount($initialize_data);
                    $this->increase_income($initialize_data);
                break;
                default:
            }

            $message = $data->fullname." REF# ".$data->reference." Has Been Successfully Paid";

            DB::commit();
            if($this->check_status($initialize_data)->status == 2)
                return ["payment_status"=>2,"status"=>"swal.success","message"=>$message];
            else
                return ["payment_status"=>1,"status"=>"swal.success","message"=>$message];
        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
    }
    public function show_payment_history($reference)
    {

        $query = PaymentAccount::with('client:id,unique_id')
        ->where('payment_account.reference',$reference)
        ->first();

        $datas = Payment::select('payment.*','users.name','payment_account.account_no')
        ->join('users','users.id','=','payment.user_id')
        ->join('payment_account','payment_account.reference','=','payment.reference')
        ->where('payment.reference',$reference)
        ->paginate(10);

        $data = [
            'query'     =>  $query,
            'datas'     =>  $datas,
            'reference' =>  $reference,
        ];

        return $data;
    }
    public function print_payment_account($reference)
    {
        $transactions = Soa::with('user','client')
        ->where(['reference'=>$reference])
        ->first();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $transactions->disbursement_date)->format('d/m/Y');

        $data = [
            'transactions'    => $transactions,
            'date'            => $date,
        ];

        return $data;
    }
    public function download_agreement($soa_id,$reference)
    {
        $soa_id = Crypt::decrypt($soa_id);

        $agreement = Agreement::with('client:id,unique_id')->where(['soa_id'=>$soa_id])->first();

        $files = [
            public_path('storage/agreement/pdf/'.$agreement->client->unique_id .'/'.$agreement->pdf),
            public_path('storage/agreement/valid_id/'.$agreement->client->unique_id.'/'.$agreement->valid_id),
        ];
        if(file_exists($files[0])&&file_exists($files[1]))
        {
            $zipFileName = 'agreement_'.strtolower($reference).'.zip';
            $zipFilePath = storage_path($zipFileName);
            Madzipper::make($zipFilePath)->add($files)->close();
            return response()->download($zipFilePath);
        }
        else
        {
            return ["status"=>"swal.error","message"=>'File not found.'];
        }
    }
    public function mail_attachment($reference){
        $transactions = Soa::with('user','client')
        ->where(['reference'=>$reference])
        ->first();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $transactions->disbursement_date)->format('d/m/Y');

        $response = [
            'transactions'    => $transactions,
            'date'            => $date,
            'image_path'      => public_path('assets/images/print-icon.png'),
        ];

        $pdf = PDF::loadView('pdf.invoice', compact('response'));
        Mail::send('mail.notification',$response, function($message)use($response,$pdf)
        {
            $message->to($response['transactions']->client->email)
                    ->subject("Angels Mini Lending Invoice Attachment")
                    ->attachData($pdf->output(), "aml-invoice_".$response['transactions']->reference.".pdf")
                    ->from(env('MAIL_USERNAME'));
        });

        return ["status"=>"swal.success","message"=>"Email sent successfully."];
    }

}
