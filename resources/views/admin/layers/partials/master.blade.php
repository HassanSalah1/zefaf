<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Zefaf CMS">
    <meta name="author" content="Zefaf">

    <link rel="shortcut icon" href="{{url('/dashboard/images/users/logo@2x.png')}}">

    <title>{{$title}}</title>

{{-- plugins --}}
@yield('style')
<!-- App css -->
    <link href="{{url('/dashboard/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{url('/dashboard/css/icons.css')}}" rel="stylesheet" type="text/css"/>

    @if($locale === 'ar' || $locale === 'ur')
        <link href="{{url('/dashboard/css/rtl/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('/dashboard/css/custom/styles_ar.css')}}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{url('/dashboard/css/ltr/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('/dashboard/css/custom/styles_en.css')}}" rel="stylesheet" type="text/css"/>
    @endif

    <script src="{{url('/dashboard/js/modernizr.min.js')}}"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js"></script>

{{--        <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase.js"></script>--}}
{{--        <script src="https://www.gstatic.com/firebasejs/4.6.2/firebase-app.js"></script>--}}
    <script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-messaging.js"></script>

{{--    <script type="text/javascript" data-cfasync="false">--}}
{{--        var _foxpush = _foxpush || [];--}}
{{--        _foxpush.push(['_setDomain', 'amgen360careintermarkfileupcom']);--}}
{{--        (function(){--}}
{{--            var foxscript = document.createElement('script');--}}
{{--            foxscript.src = '//cdn.foxpush.net/sdk/foxpush_SDK_min.js';--}}
{{--            foxscript.type = 'text/javascript';--}}
{{--            foxscript.async = 'true';--}}
{{--            var fox_s = document.getElementsByTagName('script')[0];--}}
{{--            fox_s.parentNode.insertBefore(foxscript, fox_s);})();--}}
{{--    </script>--}}

</head>

<body class="fixed-left">

<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="logo">
                <p class="logo-span">zefaf</p>
                <span class="logo-span2"></span>
            </div>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">

                <!-- Page title -->
                <ul class="nav navbar-nav list-inline navbar-left">
                    <li class="list-inline-item">
                        <button class="button-menu-mobile open-left">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                    <li class="list-inline-item">
                        <h4 class="page-title">{{$title}}</h4>
                    </li>
                </ul>

                <nav class="navbar-custom">

                    <ul class="list-unstyled topbar-right-menu float-right mb-0">

                        <li>
                            <!-- Notification -->
                        {{--<div class="notification-box">--}}
                        {{--<ul class="list-inline mb-0">--}}
                        {{--<li>--}}
                        {{--<a href="javascript:void(0);" class="right-bar-toggle">--}}
                        {{--<i class="mdi mdi-bell-outline noti-icon"></i>--}}
                        {{--</a>--}}
                        {{--<div class="noti-dot">--}}
                        {{--<span class="dot"></span>--}}
                        {{--<span class="pulse"></span>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                        <!-- End Notification bar -->
                        </li>
                    </ul>
                </nav>
            </div><!-- end container -->
        </div><!-- end navbar -->
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!-- User -->
            <div class="user-box">
                <div class="user-img">
                    <img
                        src="{{url('/dashboard/images/users/logo@2x.png')}}"
                        alt="user-img" title=" @if(isset($user) && $user) {{$user->name}} @else Admin @endif "
                        class="rounded-circle img-thumbnail img-responsive">
                    <div class="user-status online"><i class="mdi mdi-adjust"></i></div>
                </div>
                <h5><a href="#"> @if(isset($user) && $user) {{$user->name}} @else Admin @endif </a></h5>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{url('/profile/update')}}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </li>
{{--                    <li class="list-inline-item">--}}
{{--                        <a href="{{url('/setting')}}">--}}
{{--                            <i class="mdi mdi-settings"></i>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <li class="list-inline-item">
                        <a href="{{url("/logout")}}" class="text-custom">
                            <i class="mdi mdi-power"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End User -->

            <!--- Sidemenu -->
        @include('admin.layers.partials.side_bare')
        <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>

    </div>
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div> <!-- container -->
        </div> <!-- content -->

        <footer class="footer text-right">
            {{date('Y')}} © Copy Rights reserved for <a class="rights"
                                                        href="https://milestone-apps.com/">milestone-apps</a>
        </footer>

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


    {{--    @include('layers.partials.notification_bar')--}}

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="{{url('/dashboard/js/jquery.min.js')}}"></script>
<script src="{{url('/dashboard/js/popper.min.js')}}"></script>
<script src="{{url('/dashboard/js/bootstrap.min.js')}}"></script>
<script src="{{url('/dashboard/js/detect.js')}}"></script>
<script src="{{url('/dashboard/js/fastclick.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.blockUI.js')}}"></script>
<script src="{{url('/dashboard/js/waves.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.nicescroll.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.slimscroll.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.scrollTo.min.js')}}"></script>
<!-- Dashboard init -->
{{--<script src="assets/pages/jquery.dashboard.js')}}"></script>--}}
<script>
    var baseNotificationLink = '{{url('/')}}';
</script>
{{--@if($user && ($user->role === \App\Entities\UserRoles::ADMIN--}}
{{--                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&--}}
{{--                    ($permissions->{\App\Entities\PermissionKey::USERS} === 1 ||--}}
{{--                    $permissions->{\App\Entities\PermissionKey::LAP_TESTS_JOURNEY} === 1 ||--}}
{{--                    $permissions->{\App\Entities\PermissionKey::PRODUCT_DELIVERY_JOURNEY} === 1 ||--}}
{{--                    $permissions->{\App\Entities\PermissionKey::NURSE_VISIT_JOURNEY} === 1)) ))--}}
{{--    <!-- Dashboard init -->--}}
{{--    <script src="{{url('/dashboard/js/firebase.js')}}"></script>--}}
{{--@endif--}}
<!-- App js -->
<script src="{{url('/dashboard/js/jquery.core.js')}}"></script>
<script src="{{url('/dashboard/js/jquery.app.js')}}"></script>
@yield('script')
</body>

</html>
