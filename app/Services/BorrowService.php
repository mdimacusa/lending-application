<?php

namespace App\Services;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use App\Events\EventNotification;
use App\Models\Rate;
use App\Models\Client;
use App\Models\CompanyWallet;
use App\Models\Notification;
use App\Models\Soa;
use App\Models\PaymentAccount;
use App\Models\CompanyWalletHistory;
use App\Models\Agreement;
use App\Interfaces\BorrowServiceInterface;

class BorrowService implements BorrowServiceInterface
{
    public function initialize_data($data,$pdf_file,$valid_id)
    {
        $data = (object)$data;

        $init_data = [
            'uniqueid'           => $data->unique_id??'',
            'processed_by'       => auth()->user()->id ,
            'client'             => $this->get_client($data->unique_id),
            'rate'               => $this->get_rate($data->rate)->rate,
            'tenurity'           => $data->tenurity,
            'amount'             => $data->amount,
            'reference'          => 'AML'.rand(11111,99999).date('Y'),
            'fund_reference'     => 'DEB'.rand(11111,99999).date('Y'),
            'disbursement_date'  => $data->disbursement_date,
            'company_wallet'     => $this->get_company_wallet(),
            'pdf_file'           => $pdf_file,
            'valid_id'           => $valid_id,
        ];

        extract($init_data);

        $init_data['fullname']           = !empty($client->middle_name)?$client->first_name.' '.$client->middle_name.' '.$client->surname:$client->first_name.' '.$client->surname;
        $init_data['partial_interest']   = $amount * $rate;
        $init_data['interest']           = ($amount*$rate)*$tenurity;
        $init_data['loan_outstanding']   = $init_data['interest']+$amount;
        $init_data['monthly']            = $init_data['loan_outstanding']/$tenurity;
        $init_data['upcoming_due_date']  = (new Carbon($disbursement_date))->addMonth();
        $init_data['due_date']           = (new Carbon($disbursement_date))->addMonths($tenurity);

        return $init_data;
    }
    public function get_rates()
    {
        $query = Rate::get();
        return $query;
    }
    public function get_rate($rate)
    {
        $query = Rate::where('id',$rate)->first();
        return $query;
    }
    public function get_client($uniqueid)
    {
        $query = Client::where(['unique_id'=>$uniqueid,'status'=>'ACTIVE'])->first();
        return $query;
    }
    public function get_company_wallet()
    {
        $query = CompanyWallet::get();
        return $query;
    }
    public function insert_soa($init_data)
    {

        $query = Soa::insertGetId([
            'client_id'         => $init_data['client']->id,
            'user_id'           => $init_data['processed_by'],
            'fullname'          => $init_data['fullname'],
            'rate'              => $init_data['rate'],
            'amount'            => $init_data['amount'],
            'tenurity'          => $init_data['tenurity'],
            'interest'          => $init_data['interest'],
            'loan_outstanding'  => $init_data['loan_outstanding'],
            'monthly'           => $init_data['monthly'],
            'reference'         => $init_data['reference'],
            'disbursement_date' => $init_data['disbursement_date'],
            'upcoming_due_date' => $init_data['upcoming_due_date'],
            'due_date'          => $init_data['due_date'],
            'status'            => 0,
        ]);
        return $query;
    }
    public function insert_payment_account($init_data)
    {
        $query = PaymentAccount::insert([
            'account_no'        => 'ACC'.rand(11111,99999).date('Y'),
            'client_id'         => $init_data['client']->id,
            'user_id'          => $init_data['processed_by'],
            'fullname'          => $init_data['fullname'],
            'rate'              => $init_data['rate'],
            'amount'            => $init_data['amount'],
            'tenurity'          => $init_data['tenurity'],
            'interest'          => $init_data['interest'],
            'income'            => $init_data['interest'],
            'loan_outstanding'  => $init_data['loan_outstanding'],
            'monthly'           => $init_data['monthly'],
            'reference'         => $init_data['reference'],
            'disbursement_date' => $init_data['disbursement_date'],
            'upcoming_due_date' => $init_data['upcoming_due_date'],
            'due_date'          => $init_data['due_date'],
            'status'            => 0,
        ]);
        return $query;
    }
    public function insert_company_wallet_history($init_data)
    {
        $query = CompanyWalletHistory::insert([
            'user_id'  => $init_data['processed_by'],
            'reference' => $init_data['fund_reference'],
            'amount'    => $init_data['amount'],
            'status'    => 'DEBIT',
        ]);
        return $query;
    }
    public function upload_agreement($init_data,$soa_id)
    {
        $data = (object)$init_data;

        $pdf = $data->pdf_file;
        $pdfName = 'pdf_agreement_'.date("Ymd_His").'.'.$pdf->getClientOriginalExtension();
        $pdf->storeAs('public/agreement/pdf/'.$data->client->unique_id, $pdfName);

        $valid_id = $data->valid_id;
        $valid_id_name = 'valid_id_agreement_'.date("Ymd_His").'.'.$valid_id->getClientOriginalExtension();
        $valid_id->storeAs('public/agreement/valid_id/'.$data->client->unique_id, $valid_id_name);


        $query = Agreement::insert([
            'client_id' => $data->client->id,
            'soa_id'    => $soa_id,
            'pdf'       => $pdfName,
            'valid_id'  => $valid_id_name,
        ]);
        return $data;
    }
    public function borrow_notifications($init_data)
    {
        $query = Notification::insert([
            'client_id'  => $init_data['client']->id,
            'user_id'    => $init_data['processed_by'],
            'name'       => $init_data['fullname'],
            'reference'  => $init_data['reference'],
            'category'   => 'Borrow',
            'type'       => 'DEBIT',
            'amount'     => $init_data['amount'],
            'message'    => "The amount of ₱".number_format($init_data['amount'],2)." with REF# ".$init_data['reference']." Has Been Successfully Borrowed",
        ]);

        return $query;
    }
    public function deducted_company_notifications($init_data)
    {
        $query = Notification::insert([
            'client_id'  => $init_data['client']->id,
            'user_id'    => $init_data['processed_by'],
            'name'       => $init_data['fullname'],
            'reference'  => $init_data['fund_reference'],
            'category'   => 'Fund',
            'type'       => 'DEBIT',
            'amount'     => $init_data['amount'],
            'message'    => "The amount of ₱".number_format($init_data['amount'],2)." Has Been Successfully Deducted with REF# ".$init_data['fund_reference']." to the Company Fund",
        ]);
        return $query;
    }
    public function decrement_company_wallet($init_data)
    {
        $query = CompanyWallet::decrement('fund',$init_data['amount']);
        return $query;
    }
    public function borrow($request)
    {
        DB::beginTransaction();
        try {

            if(RateLimiter::tooManyAttempts('borrow:'.auth()->user()->id, $perMinute = 1)){
                return ["status"=>"swal.error","message"=>'Please wait '.RateLimiter::availableIn('borrow:'.auth()->user()->id).' seconds before next borrow'];
            }

            $initialize_data = $this->initialize_data($request->all(),$request->file('pdf_file'),$request->file('valid_id'));
            extract($initialize_data);

            if($company_wallet->count()==0)
            return ["status"=>"swal.error","message"=>"Invalid Fund"];
            if($company_wallet->first()->fund<$amount)
            return ["status"=>"swal.error","message"=>"Insufficient Fund"];

            $soa_id = $this->insert_soa($initialize_data);
            $this->upload_agreement($initialize_data,$soa_id);
            $this->insert_payment_account($initialize_data);
            $this->insert_company_wallet_history($initialize_data);
            $this->borrow_notifications($initialize_data);
            $this->deducted_company_notifications($initialize_data);
            $this->decrement_company_wallet($initialize_data);

            DB::commit();
            RateLimiter::hit('borrow:'.$processed_by);

            $message = "Your borrow request has been processed with REF# ".$reference." the amount of ₱".number_format($amount,2);
            //event(new EventNotification("Borrow",$message,$amount,$reference,$fullname,$client->id,$processed_by));
            return ["status"=>"swal.success","message"=>$message];

        } catch(Throwable $exception) {
            DB::rollBack();
            return ["status"=>"swal.error","message"=>$exception->getMessage()];
        }
        return $initialize_data;
    }

}
