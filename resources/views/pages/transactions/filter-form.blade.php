<a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-success fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor"></path>
        </svg>
    </span>
    Filter
</a>
<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_63edb45d28e7f" data-select2-id="select2-data-kt_menu_63edb45d28e7f" style="">
    <form class="mt-8" method="post">
        @csrf
        <!-- <div class="separator border-gray-200"></div> -->
        <div class="px-7 py-5">
            <div class="mb-10">
                <label class="form-label fw-semibold">Search</label>
                <input type="text" name="search" class="form-control" value="{{$response['filters']['search']??""}}"/>
            </div>
            <div class="mb-10">
                <label class="form-label fw-semibold">Select Rows:</label>
                <select class="form-select" name="rows">
                    <option {{$response['filters']['rows'] == 10 ? 'selected' : ''}}>10</option>
                    <option {{$response['filters']['rows'] == 25 ? 'selected' : ''}}>25</option>
                    <option {{$response['filters']['rows'] == 50 ? 'selected' : ''}}>50</option>
                    <option {{$response['filters']['rows'] == 100 ? 'selected' : ''}}>100</option>
                    <option {{$response['filters']['rows'] == 200 ? 'selected' : ''}}>200</option>
                    <option {{$response['filters']['rows'] == "All" ? 'selected' : ''}}>All</option>
                </select>
            </div>
            <div class="mb-10">
                <label class="form-label fw-semibold">From:</label>
                <input type="date" name="from" class="form-control" {{$response['filters']['from']??""}}/>
            </div>
            <div class="mb-10">
                <label class="form-label fw-semibold">To:</label>
                <input type="date" name="to" class="form-control" {{$response['filters']['to']??""}}/>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>
