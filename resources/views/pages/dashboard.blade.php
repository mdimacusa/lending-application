@extends('layout.app')
@section('container')
    <div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="#" class="text-muted text-hover-success">Main Navigation</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid">
                @include('pages.card')
			    <div class="row g-5 g-xl-10 mb-5 mb-xl-10 justify-content-center mt-3">
                    <div class="col-xl-12">
                        @if(count($fivedays_before) == 0)
                            <div class="alert alert-info py-3">No record found</div>
                        @else
                        <div class="card card-flush h-md-100">
                            <div class="card-header card-0 pt-6">
                                <div class="card-title">
                                    <h3>5 Day's Before Due</h3>
    						    </div>
                            </div>
                            <div class="card rounded-1">
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table border table-striped align-middle table-hover table-row-bordered gy-4 gs-4">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800">
                                                    <th class="min-w-125px">Name</th>
                                                    <th class="min-w-125px">Reference</th>
                                                    <th class="min-w-125px">Amount</th>
                                                    <th class="min-w-125px">Rate</th>
                                                    <th class="min-w-125px">Upcoming Due Date</th>
                                                    <th class="text-end">Due Date</th>
                                                </tr>
                                            </thead>
            							<tbody class="text-gray-600 fw-semibold">
                                            @foreach($fivedays_before as $soa)
            								<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
												<td class="min-w-125px">{{$soa->fullname}}</td>
                                                <td class="min-w-125px">{{$soa->reference}}</td>
                                                <td class="min-w-125px">₱{{number_format($soa->amount,2)}}</td>
												<td class="min-w-125px">{{$soa->rate}}</td>
                                                <th class="min-w-125px">{{$soa->upcoming_due_date}}</th>
            									<td class="text-end">{{$soa->due_date}}</td>
            								</tr>
                                            @endforeach
            							</tbody>
            						</table>
                                </div>
                                <div class="mt-3">
									{{ $fivedays_before->onEachSide(1)->links() }}
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
        $('a.dashboard').addClass('active');
    </script>
@endsection
@endsection
