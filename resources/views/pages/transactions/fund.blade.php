@extends('layout.app')
@section('container')
    <div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Fund</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="#" class="text-muted text-hover-success">Transactions</a>
						</li>
					</ul>
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<div class="m-0" data-select2-id="select2-data-134-dux9">
					    <a href="{{route('deposit.create')}}" class="btn btn-sm btn-flex fw-bold btn-success">Deposit</a>
						@include('pages.transactions.filter-form')
					</div>
				</div>
			</div>
		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid">

				<div class="row p-0 justify-content-center">
                   <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
                            <span class="fs-4 fw-semibold text-gray-400 d-block">Company Fund</span>
                            <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="36899" data-kt-initialized="1">₱{{number_format($total_fund,2)}}</span>
                        </div>
                    </div>
                </div>

			    <div class="row g-5 g-xl-10 mb-5 mb-xl-10 justify-content-center mt-3">
                    <div class="col-xl-12">
						@if(count($response['query']) == 0)
                            <div class="alert alert-info py-3">No record found</div>
                        @else
                        <div class="card rounded-1">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table border table-striped align-middle table-hover table-row-bordered gy-4 gs-4">
                                        <thead>
                                        <tr class="fw-bold fs-6 text-gray-800">
												<th class="min-w-150px">Reference</th>
												<th>Amount</th>
												<th>Deposit By</th>
            									<th class="text-end">Deposit Date</th>
            								</tr>
            							</thead>
            							<tbody>
											@foreach($response['query'] as $data)
                                            <tr>
												<td>{{$data->reference}}</td>
                                                <td>₱{{$data->amount}}</td>
												<td>{{$data->name}}</td>
                                                <td class="text-end">{{$data->created_at}}</td>
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
        $('a.deposit-fund').addClass('active');
   </script>
@endsection
@endsection
