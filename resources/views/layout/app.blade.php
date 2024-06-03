<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{asset('assets/images/angels-mini-lending.png')}}">
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Angel's Mini Lending</title>
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

	<!--begin::Theme mode setup on page load-->
	<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
	<!--end::Theme mode setup on page load-->

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            @include('layout.top-navigation')
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                @include('layout.navigation')
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    @yield('container')
                    @include('layout.footer')
                </div>
            </div>
         </div>
    </div>

    <div class="toast bg-light" id="toastElement" role="alert" aria-live="assertive" aria-atomic="true" style="position:absolute;bottom:35px;right:7px;z-index:999">
        <div class="toast-header">
            <i class="ki-duotone ki-abstract-39 fs-2 text-primary me-3"><span class="path1"></span><span class="path2"></span></i>
            <strong class="me-auto">Keenthemes</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <span id="realtimeMsg"></span>
        </div>
    </div>

    @include('layout.borrow-confirmation')

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
    $(document).ready(function()
    {
        notificationCount();
        displayBorowNotification();
        displayFundNotification();
    });
    function timeAgo(date)
    {
        const seconds = Math.floor((new Date() - date) / 1000);

        let interval = Math.floor(seconds / 31536000);
        if (interval > 1) {
            return interval + " years ago";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months ago";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days ago";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours ago";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes ago";
        }
        return Math.floor(seconds) + " seconds ago";
    }

    function notificationCount() {
        $.ajax({
            url: "{{ url('/notification-count') }}",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data === 0){
                }else{
                    $('#notification-count').text(data).css({
                        'width':'15px',
                        'height':'15px',
                        'position':'absolute',
                        'top':'-5px',
                        'right':'1px',
                        'font-size':'8px',
                        'font-weight':'bold',
                        'color':'#ffffff',
                        'background':'#F3416C',
                        'border-radius': '40%',
                        'text-align':'center',
                        'padding-top':'1px',
                    });
                }
            }
        });
    }
    function displayBorowNotification() {
        $('#borrowNotification').empty();
        $('#borrowNotificationCount').empty();
        $.ajax({
            url: "{{ url('/borrow-notification') }}",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data.length === 0)
                {
                    $('#borrowNotificationCount').append(
                        '<div class="d-flex justify-content-center">'+
                            '<p>No Found Data</p>'+
                        '</div>'
                    );
                }
                else
                {
                    $.each(data, function(index, item) {
                        let type = `${(item.type=='DEBIT')?'danger':'success'}`
                        $('#borrowNotification').append(
                            '<div class="d-flex flex-stack py-4" >'+
                                '<div class="d-flex align-items-center">'+
                                    '<div class="symbol symbol-35px me-4">'+
                                        '<span class="symbol-label bg-light-'+type+'">'+
                                            '<span class="svg-icon svg-icon-muted svg-icon-2x">'+
                                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'+
                                                    '<path opacity="0.9" d="M20 18H4C3.4 18 3 17.6 3 17V7C3 6.4 3.4 6 4 6H20C20.6 6 21 6.4 21 7V17C21 17.6 20.6 18 20 18ZM12 8C10.3 8 9 9.8 9 12C9 14.2 10.3 16 12 16C13.7 16 15 14.2 15 12C15 9.8 13.7 8 12 8Z" fill="currentColor"/>'+
                                                    '<path d="M18 6H20C20.6 6 21 6.4 21 7V9C19.3 9 18 7.7 18 6ZM6 6H4C3.4 6 3 6.4 3 7V9C4.7 9 6 7.7 6 6ZM21 17V15C19.3 15 18 16.3 18 18H20C20.6 18 21 17.6 21 17ZM3 15V17C3 17.6 3.4 18 4 18H6C6 16.3 4.7 15 3 15Z" fill="currentColor"/>'+
                                                '</svg>'+
                                            '</span>'+
                                        '</span>'+
                                    '</div>'+
                                    '<div class="mb-0 me-2">'+
                                        '<a href="#" class="fs-8 text-gray-800 text-hover-success fw-bold">'+item.message+'</a>'+
                                        '<div class="text-gray-500 fs-8">'+timeAgo(new Date(item.created_at))+'</div>'+
                                    '</div>'+
                                '</div>'+
                                '<span class="badge badge-light fs-8" style="background: none;">'+
                                    '<a href="javascript:void(0)" onclick="seenFunction('+item.id+')" id="seen">Mark as read</a>'+
                                '</span>'+
                            '</div>'
                        );
                    });
                }
            }
        });
    }

    function displayFundNotification() {
        $('#fundNotification').empty();
        $('#fundNotificationCount').empty();
        $.ajax({
            url: "{{ url('/fund-notification') }}",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data.length === 0)
                {
                    $('#fundNotificationCount').append(
                        '<div class="d-flex justify-content-center">'+
                            '<p>No Found Data</p>'+
                        '</div>'
                    );
                }
                else
                {
                    $.each(data, function(index, item) {
                        let type = `${(item.type=='DEBIT')?'danger':'success'}`
                        $('#fundNotification').append(
                            '<div class="d-flex flex-stack py-4" >'+
                                '<div class="d-flex align-items-center">'+
                                    '<div class="symbol symbol-35px me-4">'+
                                        '<span class="symbol-label bg-light-'+type+'">'+
                                            '<span class="svg-icon svg-icon-muted svg-icon-2x">'+
                                                '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">'+
                                                    '<path opacity="0.9" d="M20 18H4C3.4 18 3 17.6 3 17V7C3 6.4 3.4 6 4 6H20C20.6 6 21 6.4 21 7V17C21 17.6 20.6 18 20 18ZM12 8C10.3 8 9 9.8 9 12C9 14.2 10.3 16 12 16C13.7 16 15 14.2 15 12C15 9.8 13.7 8 12 8Z" fill="currentColor"/>'+
                                                    '<path d="M18 6H20C20.6 6 21 6.4 21 7V9C19.3 9 18 7.7 18 6ZM6 6H4C3.4 6 3 6.4 3 7V9C4.7 9 6 7.7 6 6ZM21 17V15C19.3 15 18 16.3 18 18H20C20.6 18 21 17.6 21 17ZM3 15V17C3 17.6 3.4 18 4 18H6C6 16.3 4.7 15 3 15Z" fill="currentColor"/>'+
                                                '</svg>'+
                                            '</span>'+
                                        '</span>'+
                                    '</div>'+
                                    '<div class="mb-0 me-2">'+
                                        '<a href="#" class="fs-8 text-gray-800 text-hover-success fw-bold">'+item.message+'</a>'+
                                        '<div class="text-gray-500 fs-8">'+timeAgo(new Date(item.created_at))+'</div>'+
                                    '</div>'+
                                '</div>'+
                                '<span class="badge badge-light fs-8" style="background: none;">'+
                                    '<a href="javascript:void(0)" onclick="seenFunction('+item.id+')" id="seen">Mark as read</a>'+
                                '</span>'+
                            '</div>'
                        );

                    });
                }
            }
        });
    }

    function seenFunction(id)
    {
        var urlLink = "{{url('/seen-notification')}}/"+id;
        $.ajax({
            url: urlLink,
            type: 'GET',
            success: function(data) {
                notificationCount();
                displayBorowNotification();
                displayFundNotification();
            }
        });
    }
    </script>

    <script>
		    $("#password-lock").click(function(){
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                    $(this).removeClass('far fa-eye').addClass('far fa-eye-slash')
                } else {
                    x.type = "password";
                    $(this).removeClass('far fa-eye-slash').addClass('far fa-eye')
                }
		    })
            $("#password-lock-confirmation").click(function(){
                var x = document.getElementById("password-confirmation");
                if (x.type === "password") {
                    x.type = "text";
                    $(this).removeClass('far fa-eye').addClass('far fa-eye-slash')
                } else {
                    x.type = "password";
                    $(this).removeClass('far fa-eye-slash').addClass('far fa-eye')
                }
		    })
	</script>

    @if(Session::has('swal.message'))
        <script>
        Swal.fire({
            html: "<span class='fs-8 text-uppercase fw-bold'>{!!Session::get('swal.message')!!}</span>",
            icon: "info",
            customClass: {
                confirmButton: "btn btn-primary btn-sm"
            }
        });
        </script>
    @endif
    @if(Session::has('swal.success'))
        <script>
        Swal.fire({
            html: "<span class='fs-8 text-uppercase fw-bold'>{!!Session::get('swal.success')!!}</span>",
            icon: "success",
            customClass: {
                confirmButton: "btn btn-success btn-sm"
            }
        });
        </script>
    @endif

    @if(Session::has('swal.error'))
        <script>
        Swal.fire({
            html: "<span class='fs-8 text-uppercase fw-bold'>{!!Session::get('swal.error')!!}</span>",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-success btn-sm"
            }
        });
        </script>
    @endif

    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('d89b2afbc344cd86fa73', {
        cluster: 'ap1'
        });

        var channel = pusher.subscribe('borrow-channel');
        channel.bind('borrow-event', function(data) {
            $('#realtimeMsg').html(data.message);
            var a = document.getElementById('toastElement');
            setTimeout(() => {
                a.classList.add("show")
            }, 250);
        });

    </script>

    @yield('custom')

</body>

</html>
