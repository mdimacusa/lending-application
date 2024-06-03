<span class="d-flex mb-5 position-relative">
    <span class="d-inline-block mb-2 fs-5 text-uppercase fw-bold text-gray-900">
        Administrator Details
    </span>
    <span class="d-inline-block position-absolute h-2px bottom-0 end-0 start-0 bg-success translate rounded"></span>
</span>
<div class="d-flex flex-stack">
    <div class="text-gray-700 fw-semibold fs-6 me-2">Unique ID</div>
    <div class="d-flex align-items-senter">
        <span class="text-gray-900 fw-bolder fs-6">{{$response['administrator']->unique_id}}</span>
    </div>
</div>
<div class="separator separator-dashed my-3"></div>
<div class="d-flex flex-stack">
    <div class="text-gray-700 fw-semibold fs-6 me-2">Name</div>
    <div class="d-flex align-items-senter">
        <span class="text-gray-900 fw-bolder fs-6">{{$response['administrator']->name}}</span>
    </div>
</div>
<div class="separator separator-dashed my-3"></div>
<div class="d-flex flex-stack">
    <div class="text-gray-700 fw-semibold fs-6 me-2">Email</div>
    <div class="d-flex align-items-senter">
        <span class="text-gray-900 fw-bolder fs-6">{{$response['administrator']->email}}</span>
    </div>
</div>
<div class="separator separator-dashed my-3"></div>

@if($response['tab']=="deposit")
    <a href="#" class="card bg-body shadow-sm hoverable card-xl-stretch mb-5">
        <div class="card-body">
            <div class="text-gray-900 fw-bold fs-2 mb-2">₱{{number_format($response['total_deposit'],2)}}</div>
            <div class="fw-semibold text-gray-800 text-uppercase fs-9">Total Deposit</div>
        </div>
    </a>
@else
    <a href="#" class="card bg-body shadow-sm hoverable card-xl-stretch mb-5">
        <div class="card-body">
            <div class="text-gray-900 fw-bold fs-2 mb-2">₱{{number_format($response['administrator_fully_paid'],2)}}</div>
            <div class="fw-semibold text-gray-800 text-uppercase fs-9">Fully Paid</div>
        </div>
    </a>
    <a href="#" class="card bg-body shadow-sm hoverable card-xl-stretch mb-5">
        <div class="card-body">
            <div class="text-gray-900 fw-bold fs-2 mb-2">₱{{number_format($response['administrator_partially_paid'],2)}}</div>
            <div class="fw-semibold text-gray-800 text-uppercase fs-9">Partially Paid</div>
        </div>
    </a>
    <a href="#" class="card bg-body shadow-sm hoverable card-xl-stretch mb-5">
        <div class="card-body">
            <div class="text-gray-900 fw-bold fs-2 mb-2">₱{{number_format($response['administrator_unpaid'],2)}}</div>
            <div class="fw-semibold text-gray-800 text-uppercase fs-9">Unpaid</div>
        </div>
    </a>
@endif
