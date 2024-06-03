@extends('layout.app')
@section('container')
    <div class="d-flex flex-column flex-column-fluid">
		<!--begin::Toolbar-->
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<!--begin::Toolbar container-->
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<!--begin::Title-->
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Top Borrower</h1>
					<!--end::Title-->
					<!--begin::Breadcrumb-->
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<!--begin::Item-->
						<li class="breadcrumb-item text-muted">
							<a href="#" class="text-muted text-hover-success">Reports</a>
						</li>
					</ul>
					<!--end::Breadcrumb-->
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<div class="m-0" data-select2-id="select2-data-134-dux9">
						@include('pages.report.filter-form')
                        <a href="{{route('top-borrower.export').'?'.http_build_query($response['filters'])}}" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-success fw-bold">Download</a>
					</div>

				</div>
			</div>
			<!--end::Toolbar container-->

		</div>
		<!--end::Toolbar-->
		<!--begin::Content-->
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<!--begin::Content container-->
			<div id="kt_app_content_container" class="app-container container-fluid">

			    <div class="row g-5 g-xl-10 mb-5 mb-xl-10 justify-content-center">
                    <div class="col-xl-12">
                        @if(count($response['query']) == 0)
                            <div class="alert alert-info py-3">No record found</div>
                        @else
                        <div class="card rounded-1">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table border table-striped align-middle table-hover table-row-bordered gy-4 gs-4">
            							<thead>
            								<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
												<th class="min-w-150px">Client Unique ID</th>
												<th>Fullname</th>
												<th class="text-end">Total Amount</th>
            								</tr>
            							</thead>
            							<tbody class="text-gray-600 fw-semibold">
											@foreach($response['query'] as $data)
                                            <tr>
												<td>{{$data->unique_id}}</td>
                                                <td>{{$data->fullname}}</td>
                                                <td class="text-end">₱{{$data->borrowed_amount}}</td>
                                            </tr>
											@endforeach
            							</tbody>
            						</table>
                                </div>
                                @if($response['filters']['rows'] != "All")
                                    {{ $response['query']->onEachSide(1)->links() }}
                                @endif
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
        $('a.top-borrower').addClass('active');
   </script>
@endsection
@endsection
