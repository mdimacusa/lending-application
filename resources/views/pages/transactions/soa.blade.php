@extends('layout.app')
@section('container')
    <div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Payment</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="#" class="text-muted text-hover-success">Transactions</a>
						</li>
					</ul>
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<div class="m-0" data-select2-id="select2-data-134-dux9">
						@include('pages.transactions.filter-form')
						{{--<a href="{{url('transactions/deposit-fund/download').'?'.http_build_query($response['filters'])}}" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-success fw-bold">Download</a>--}}
					</div>

				</div>
			</div>
		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid">

			    <div class="row g-5 g-xl-10 mb-5 mb-xl-10 justify-content-center">
                    <div class="col-xl-12">
						@if(count($response['query']) == 0)
                            <div class="alert alert-info py-3">No record found</div>
                        @else
                        <div class="card card-flush h-md-100">
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h3>Original's Copy</h3>
    						    </div>
                            </div>
                            <div class="card rounded-1">
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table border table-striped align-middle table-hover table-row-bordered gy-4 gs-4">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-175px">Client Details</th>
                                                    <th class="min-w-175px">Status</th>
                                                    <th class="min-w-175px">Remarks</th>
                                                    <th class="min-w-175px">Loan Details</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>
            							<tbody class="text-gray-600 fw-semibold">
											@foreach($response['query'] as $data)
                                            <tr>
												<td>
													<div class="fs-5">Name : {{$data->fullname}}</div>
													<div class="fs-5">Reference : <span class="text-primary">{{$data->reference}}</span><div>
													<div class="fs-5">Client Unique ID : {{$data->client->unique_id}}<div>
												</td>
												<td>
													@if($data->status == "0")
													<div class="badge badge-light-danger fs-6">UNPAID</div>
													@elseif($data->status == "1")
													<div class="badge badge-light-primary fs-6">PARTIALLY PAID</div>
													@else
													<div class="badge badge-light-success fs-6">FULLY PAID</div>
													@endif
												</td>
												<td class="min-w-175px">{{$data->remarks??'NO DATA'}}</td>
												<td>
													<div class="fs-7">Rate : {{$data->rate}} %</div>
													<div class="fs-7">Amount : ₱{{$data->amount}}<div>
													<div class="fs-7">Tenurity : {{$data->tenurity}}<div>
													<div class="fs-7">Interest : {{$data->interest}}</div>
													<div class="fs-7">Loan Outstanding : ₱{{$data->loan_outstanding}}<div>
													<div class="fs-7">Monthly : ₱{{$data->monthly}}<div>
													<div class="fs-7">Current Loan Outstanding : <span class="badge badge-light-primary fs-7 mb-1">{{$data->current_loan_outstanding??'NO DATA'}}</span></div>
													{{--<div class="fs-7">Balance Amount : <span class="badge badge-light-primary fs-7 mb-1">{{$data->balance_amount??'NO DATA'}}</span></div>--}}
													<div class="fs-7">Payment Method : <span class="badge badge-light-primary fs-7 mb-1">{{$data->payment_method??'NO DATA'}}</span></div>
													<div class="fs-7">Payment Amount : <span class="badge badge-light-primary fs-7">{{$data->payment_amount??'NO DATA'}}</span><div>
													<div class="fs-7">Disbursement Date : {{date('M d, Y', strtotime($data->disbursement_date))}}<div>
													<div class="fs-7">Last Payment Date : <span class="badge badge-light-primary fs-7 mb-1">{{empty($data->last_payment_date)?"NO DATA":date('M d, Y', strtotime($data->last_payment_date))}}</span></div>
													<div class="fs-7">Upcoming Due Date : <span class="badge badge-light-primary fs-7">{{empty($data->upcoming_due_date)?"NO DATA":date('M d, Y', strtotime($data->upcoming_due_date))}}</span><div>
													<div class="fs-7">Due Date : {{date('M d, Y', strtotime($data->due_date))}}<div>
                                                    @if($data->status==2)
                                                    <div class="fs-7">Processed By : {{$data->user->name??'NO DATA'}}<div>
                                                    @endif
												</td>
                                                <td class="text-end">
                								    <a href="#"data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <span class="svg-icon svg-icon-muted svg-icon-2x">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path opacity="0.3" d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z" fill="currentColor"/>
                                                                <path d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z" fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                    </a>
                								    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                										@if($data->status == "0")
														<div class="menu-item px-3">
                											<a href="{{route('payment.show',['status'=>$response['status'],'payment'=>Crypt::encrypt($data->reference)])}}" class="menu-link px-3">Payment</a>
                										</div>
                                                        <div class="menu-item px-3">
                											<a href="{{route('agreement.download',['id'=>Crypt::encrypt($data->id),'reference'=>$data->reference])}}" class="menu-link px-3">Download Agreement</a>
                										</div>
														@elseif($data->status == "1")
														<div class="menu-item px-3">
                											<a href="{{route('payment.show',['status'=>$response['status'],'payment'=>Crypt::encrypt($data->reference)])}}" class="menu-link px-3">Payment</a>
                										</div>
                                                        <div class="menu-item px-3">
                											<a href="{{route('payment.history.show',['status'=>$response['status'],'reference'=>Crypt::encrypt($data->reference)])}}" class="menu-link px-3">Payment History</a>
                										</div>
                                                        <div class="menu-item px-3">
                											<a href="{{route('agreement.download',['id'=>Crypt::encrypt($data->id),'reference'=>$data->reference])}}" class="menu-link px-3">Download Agreement</a>
                										</div>
														@else
														<div class="menu-item px-3">
                											<a href="{{route('payment.history.show',['status'=>$response['status'],'reference'=>Crypt::encrypt($data->reference)])}}" class="menu-link px-3">Payment History</a>
                										</div>
                                                        <div class="menu-item px-3">
                											<a href="{{route('agreement.download',['id'=>Crypt::encrypt($data->id),'reference'=>$data->reference])}}" class="menu-link px-3">Download Agreement</a>
                										</div>
                                                        <div class="menu-item px-3">
                											<a href="{{route('send-mail.attachment',['reference'=>$data->reference])}}" class="menu-link px-3">Send Receipt Attachment</a>
                										</div>
                                                        <div class="menu-item px-3">
                											<a href="{{route('invoice',['reference'=>Crypt::encrypt($data->reference)])}}" target="_blank" class="menu-link px-3">View Receipt</a>
                										</div>
														@endif
                									</div>
                								</td>
                                            </tr>
											@endforeach
            							</tbody>
            						</table>
                                </div>
								<div class="mt-3">
									@if($response['filters']['rows'] != "All")
                                    {{ $response['query']->onEachSide(1)->links() }}
                                    @endif
								</div>
                            </div>
                        </div>
						@endif
                    </div>
                </div>
			</div>
		</div>
	</div>
@section('custom')
 	<script>
        $('.payment').addClass('hover show');
        $('.sub-payment').addClass('show');
        $('.{{$response['status']}}').addClass('text-white');
   </script>
@endsection
@endsection
