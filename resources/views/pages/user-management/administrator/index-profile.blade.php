@extends('layout.app')
@section('container')
    <div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Administrator</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">
							<a href="#" class="text-muted text-hover-success">User Management</a>
						</li>
					</ul>
				</div>
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<div class="m-0" data-select2-id="select2-data-134-dux9">
                        <a href="{{route('administrator.profile.create')}}" class="btn btn-sm btn-flex fw-bold btn-success">Create Administrator</a>
                        @if($response['tab']!="summary")
						    @include('pages.user-management.filter-form')
                        @endif
					</div>
				</div>
			</div>

		</div>
		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group w-100 mb-5">
                            <a href="{{route('administrator.profile',['tab'=>'summary','id'=>Crypt::encrypt($response['administrator']->id)])}}" class="btn blocker btn-sm {{($response['tab']=="summary"?'btn-default':'btn-sm btn-light-success')}}">Summary</a>
                            <a href="{{route('administrator.profile',['tab'=>'transaction','id'=>Crypt::encrypt($response['administrator']->id)])}}" class="btn blocker btn-sm {{($response['tab']=="transaction"?'btn-default':'btn-sm btn-light-success')}}">Transaction</a>
                            <a href="{{route('administrator.profile',['tab'=>'deposit','id'=>Crypt::encrypt($response['administrator']->id)])}}" class="btn blocker btn-sm {{($response['tab']=="deposit"?'btn-default':'btn-sm btn-light-success')}}">Deposit</a>
                        </div>
                    </div>
                </div>
			    <div class="row g-5 g-xl-10 mb-xl-10 justify-content-center">
                    <div class="col-md-12">
                        @include('pages.user-management.administrator.tab')
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
@section('custom')
 	<script>
        $('a.administrator').addClass('active');
   </script>
@endsection
@endsection

