@if($response['tab']=="summary")
    @include('pages.user-management.administrator.summary')
@elseif($response['tab']=="deposit")
    @if(count($response['query']) == 0)
    <div class="alert alert-info py-3">No record found</div>
    @else
    <div class="row">
        <div class="col-md-9 col-12 mb-5">
            @include('pages.user-management.administrator.deposit')
        </div>
        <div class="col-md-3 col-12">
            @include('pages.user-management.administrator.detail')
        </div>
    </div>
    @endif
@else
    @if(count($response['query']) == 0)
        <div class="alert alert-info py-3">No record found</div>
    @else
    <div class="row">
        <div class="col-md-9 col-12 mb-5">
            @include('pages.user-management.administrator.transaction')
        </div>
        <div class="col-md-3 col-12">
            @include('pages.user-management.administrator.detail')
        </div>
    </div>
    @endif
@endif
