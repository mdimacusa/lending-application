<div class="app-navbar-item ms-3 ms-lg-9" id="kt_header_notifications_menu">
    <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
        <div class="cursor-pointer symbol symbol symbol-circle symbol-35px symbol-md-40px">
            <span class="svg-icon svg-icon-muted svg-icon-2x"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="currentColor"/>
                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="currentColor"/>
                </svg>
            </span>
            <span id="notification-count"></span>
        </div>
    </div>

    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{url('assets/images/menu-header-bg.jpg')}}')">
            <!--begin::Title-->
            <h3 class="fw-semibold px-9 mt-10 mb-6 text-white">Notifications
            <span class="fs-6 opacity-75 ps-3"></span></h3>
            <!--end::Title-->
            <!--begin::Tabs-->
            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                <li class="nav-item">
                    <a class="nav-link opacity-75 opacity-state-100 pb-4 text-white active" data-bs-toggle="tab" href="#borrow_notifications">Borrow</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link opacity-75 opacity-state-100 pb-4 text-white" data-bs-toggle="tab" href="#fund_notifications">Fund</a>
                </li>
            </ul>
            <!--end::Tabs-->
        </div>
        <div class="separator my-2"></div>
        <div class="tab-content">

            <div class="tab-pane show active fade" id="borrow_notifications" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    <span id="borrowNotificationCount"></span>
                    <span id="borrowNotification"></span>
                </div>
            </div>
            <div class="tab-pane fade" id="fund_notifications" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">

                    <span id="fundNotificationCount"></span>
                    <span id="fundNotification"></span>
                </div>
            </div>
        </div>
    </div>
</div>

