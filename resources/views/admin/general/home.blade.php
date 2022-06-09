@extends('admin.layers.partials.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel panel-default" data-panel-control data-sortable="true">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {{trans('admin.statistics')}}
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">

                            @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                        || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        ($permissions->{\App\Entities\PermissionKey::USERS} == 1 )) ))
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-primary"
                                       href="{{url('/users')}}">
                                        <span class="number counter">{{$all_clients}}</span>
                                        <span class="name">All Users</span>
                                    </a>
                                </div>
                            @endif

                                @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                    ($permissions->{\App\Entities\PermissionKey::USERS} == 1 )) ))
                                    <div class="col-md-3">
                                        <a class="dashboard-stat bg-warning"
                                           href="#">
                                            <span class="number counter">{{$partner_clients}}</span>
                                            <span class="name">All Users With Partner Name</span>
                                        </a>
                                    </div>
                                @endif

                            @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                        || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) ))
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-inverse"
                                       href="{{url('/vendors')}}">
                                        <span class="number counter">{{$all_vendors}}</span>
                                        <span class="name">All Vendors</span>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-success"
                                       href="{{url('/vendors?status='.\App\Entities\UserStatus::ACTIVE)}}">
                                        <span class="number counter">{{$active_vendors}}</span>
                                        <span class="name">Active Vendors</span>
                                    </a>
                                </div>

                            @endif

                        </div>

                        <div class="row">
                            @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                                   || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                                   ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) ))

                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-warning"
                                       href="{{url('/vendors?status='.\App\Entities\UserStatus::REVIEW)}}">
                                        <span class="number counter">{{$pending_vendors}}</span>
                                        <span class="name">In review Vendors</span>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-danger"
                                       href="{{url('/vendors?status='.\App\Entities\UserStatus::BLOCKED)}}">
                                        <span class="number counter">{{$blocked_vendors}}</span>
                                        <span class="name">Inactive Vendors</span>
                                    </a>
                                </div>
                            @endif

                            @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                       || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                       ($permissions->{\App\Entities\PermissionKey::CATEGORIES} == 1 )) ))
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-success"
                                       href="{{url('/categories')}}">
                                        <span class="number counter">{{$categories}}</span>
                                        <span class="name">Categories</span>
                                    </a>
                                </div>
                            @endif

                            @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                   || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                   ($permissions->{\App\Entities\PermissionKey::EMPLOYEES} == 1 )) ))
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-inverse"
                                       href="{{url('/employees')}}">
                                        <span class="number counter">{{$employees}}</span>
                                        <span class="name">employees</span>
                                    </a>
                                </div>
                            @endif


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('script')

    <script src="{{url('/dashboard/js/waypoints/waypoints.min.js')}}"></script>
    <script src="{{url('/dashboard/js/jquery.counterup.min.js')}}"></script>
    <script src="{{url('/dashboard/js/components/toastr.min.js')}}"></script>
    <script>
        $(function () {
            // Counter for dashboard stats
            $('.counter').counterUp({
                delay: 10,
                time: 500
            });

            @if(isset($first_time) && $first_time == true)
                toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "3000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["success"]('{{trans('admin.welcome_message')}}', '{{trans('admin.welcome_title')}}');
            @endif

        })
    </script>
@stop

@section('style')
    <link href="{{url('/dashboard/css/components/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
@stop
