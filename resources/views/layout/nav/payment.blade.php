<div data-kt-menu-trigger="click" class="menu-item menu-accordion payment">
    <span class="menu-link">
        <span class="menu-icon">
            <span class="svg-icon svg-icon-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8 22C7.4 22 7 21.6 7 21V9C7 8.4 7.4 8 8 8C8.6 8 9 8.4 9 9V21C9 21.6 8.6 22 8 22Z"
                        fill="currentColor" />
                    <path opacity="0.3"
                        d="M4 15C3.4 15 3 14.6 3 14V6C3 5.4 3.4 5 4 5C4.6 5 5 5.4 5 6V14C5 14.6 4.6 15 4 15ZM13 19V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V19C11 19.6 11.4 20 12 20C12.6 20 13 19.6 13 19ZM17 16V5C17 4.4 16.6 4 16 4C15.4 4 15 4.4 15 5V16C15 16.6 15.4 17 16 17C16.6 17 17 16.6 17 16ZM21 18V10C21 9.4 20.6 9 20 9C19.4 9 19 9.4 19 10V18C19 18.6 19.4 19 20 19C20.6 19 21 18.6 21 18Z"
                        fill="currentColor" />
                </svg>
            </span>
        </span>
        <span class="menu-title">Payment</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion sub-payment" kt-hidden-height="125">
        <div class="menu-item">
            <a class="menu-link" href="{{route('payment.list',['status'=>'unpaid'])}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title unpaid">Unpaid</span>
                <span class="menu-badge badge badge-danger text-white">{{$unpaid??0}}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('payment.list',['status'=>'partially-paid'])}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title partially-paid">Partially Paid</span>
                <span class="menu-badge badge badge-primary text-white">{{$partially_paid??0}}</span>
            </a>
        </div>
        <div class="menu-item">
            <a class="menu-link" href="{{route('payment.list',['status'=>'fully-paid'])}}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title fully-paid">Full Paid</span>
                <span class="menu-badge badge badge-success text-white">{{$fully_paid??0}}</span>
            </a>
        </div>
    </div>
</div>
