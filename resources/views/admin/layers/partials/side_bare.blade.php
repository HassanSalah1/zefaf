<div id="sidebar-menu">
    <ul>
        <li class="text-muted menu-title"></li>

        {{--home--}}
        <li @if(isset($active) && $active === 'home') class="active" @endif>
            <a href="{{url("/home")}}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i>
                <span> {{trans('admin.home_title')}} </span>
            </a>
        </li>

        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::SETTINGS} == 1 ||
                $permissions->{\App\Entities\PermissionKey::CLIENT_TERMS} == 1 ||
                 $permissions->{\App\Entities\PermissionKey::COUNTRIES} == 1 ))))
            {{--setting--}}
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-gear"></i>
                    <span> {{trans('admin.setting_title')}} </span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">

                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        $permissions->{\App\Entities\PermissionKey::CLIENT_TERMS} == 1) ))
                        <li @if(isset($active) && $active == 'client_terms') class="active" @endif>
                            <a href="{{url('/client/terms')}}">{{trans('admin.client_terms_title')}}</a>
                        </li>
                    @endif

                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                   || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                       $permissions->{\App\Entities\PermissionKey::VENDOR_TERMS} == 1) ))
                        <li @if(isset($active) && $active == 'vendor_terms') class="active" @endif>
                            <a href="{{url('/vendor/terms')}}">{{trans('admin.vendor_terms_title')}}</a>
                        </li>
                    @endif

                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                $permissions->{\App\Entities\PermissionKey::MEMBERSHIPS} == 1) ))
                        <li @if(isset($active) && $active == 'memberships') class="active" @endif>
                            <a href="{{url('/memberships')}}">{{trans('admin.memberships_title')}}</a>
                        </li>
                    @endif

                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                    $permissions->{\App\Entities\PermissionKey::COUNTRIES} == 1) ))
                        <li @if(isset($active) && $active == 'countries') class="active" @endif>
                            <a href="{{url('/countries')}}">{{trans('admin.countries_title')}}</a>
                        </li>
                    @endif

                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                $permissions->{\App\Entities\PermissionKey::AREAS} == 1) ))
                        <li @if(isset($active) && $active == 'areas') class="active" @endif>
                            <a href="{{url('/areas')}}">{{trans('admin.areas_title')}}</a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif

        {{--employees list--}}
        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::PERMISSIONS} == 1 ||
                $permissions->{\App\Entities\PermissionKey::EMPLOYEES} == 1 )) ))
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user-secret"></i>
                    <span> {{trans('admin.employees_list_title')}} </span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                    $permissions->{\App\Entities\PermissionKey::PERMISSIONS} == 1) ))
                        <li @if(isset($active) && $active == 'permissions') class="active" @endif>
                            <a href="{{url('/permissions')}}">{{trans('admin.permissions_title')}}</a>
                        </li>
                    @endif
                    @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                    $permissions->{\App\Entities\PermissionKey::EMPLOYEES} == 1 ) ))
                        <li @if(isset($active) && $active == 'employees') class="active" @endif>
                            <a href="{{url('/employees')}}">{{trans('admin.employees_title')}}</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif


        {{-- categories users       --}}
        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::CATEGORIES} == 1 )) ))
            {{--categories--}}
            <li @if(isset($active) && $active === 'categories') class="active" @endif>
                <a href="{{url("/categories")}}" class="waves-effect"><i class="fa fa-paragraph"></i>
                    <span> {{trans('admin.categories_title')}} </span>
                </a>
            </li>
        @endif

        {{-- client users       --}}
        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::USERS} == 1 )) ))
            {{--users--}}
            <li @if(isset($active) && $active === 'users') class="active" @endif>
                <a href="{{url("/users")}}" class="waves-effect"><i class="fa fa-user-circle-o"></i>
                    <span> {{trans('admin.users_title')}} </span>
                </a>
            </li>
        @endif

        {{-- vendors users       --}}
        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) ))
            {{--users--}}

            <li @if(isset($active) && $active === 'add_vendor') class="active" @endif>
                <a href="{{url("/vendor/add")}}" class="waves-effect"><i class="fa fa-plus"></i>
                    <span> Add vendor </span>
                </a>
            </li>

            <li @if(isset($active) && $active === 'vendors') class="active" @endif>
                <a href="{{url("/vendors")}}" class="waves-effect"><i class="fa fa-users"></i>
                    <span> {{trans('admin.vendors_title')}} </span>
                </a>
            </li>

            <li @if(isset($active) && $active === 'vendors_review') class="active" @endif>
                <a href="{{url("/vendors/review")}}" class="waves-effect"><i class="fa fa-user-secret"></i>
                    <span>
                    {{trans('admin.vendors_review_title')}}
                    <label class="btn btn-warning btn-rounded" style="padding: 0px 5px;">
                            {{\App\Models\User\User::where(['status' => \App\Entities\UserStatus::REVIEW,'role' => \App\Entities\UserRoles::VENDOR])->count() }}
                        </label>
                    </span>
                </a>
            </li>
        @endif

        {{-- requests       --}}
        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) ))
            {{--requests--}}
            <li @if(isset($active) && $active === 'requests') class="active" @endif>
                <a href="{{url("/requests")}}" class="waves-effect"><i class="fa fa-edit"></i>
                    <span>
                        requests
                        <label class="btn btn-warning btn-rounded" style="padding: 0px 5px;">
                            {{\App\Models\User\EditRequest::where(['status' => \App\Entities\EditRequestStatus::PENDING])->count()}}
                        </label>
                    </span>
                </a>
            </li>
        @endif

        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                        || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        ($permissions->{\App\Entities\PermissionKey::NOTIFICATIONS} == 1 )) ))
            <li @if(isset($active) && $active === 'notifications') class="active" @endif>
                <a href="{{url("/notifications")}}" class="waves-effect"><i class="fa fa-inbox"></i>
                    <span> Users {{trans('admin.notifications_title')}} </span>
                </a>
            </li>

            <li @if(isset($active) && $active === 'vendors_notifications') class="active" @endif>
                <a href="{{url("/notifications/vendors")}}" class="waves-effect"><i class="fa fa-inbox"></i>
                    <span> Vendors notifications </span>
                </a>
            </li>

        @endif

        {{--employees list--}}
        @if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                $permissions->{\App\Entities\PermissionKey::REPORTS} == 1  ) ))
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bar-chart-o"></i>
                    <span> Reports </span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li @if(isset($active) && $active == 'category_reports') class="active" @endif>
                        <a href="{{url('/reports/categories')}}">Category Reports</a>
                    </li>

                    <li @if(isset($active) && $active == 'vendors_reports') class="active" @endif>
                        <a href="{{url('/reports/vendors')}}">Vendors Reports</a>
                    </li>

                    <li @if(isset($active) && $active == 'memberships_reports') class="active" @endif>
                        <a href="{{url('/reports/memberships')}}">Memberships Reports</a>
                    </li>

                    <li @if(isset($active) && $active == 'clogin_reports') class="active" @endif>
                        <a href="{{url('/reports/login?type='.\App\Entities\UserRoles::CUSTOMER)}}">Clients Login Reports</a>
                    </li>

                    <li @if(isset($active) && $active == 'vlogin_reports') class="active" @endif>
                        <a href="{{url('/reports/login?type='.\App\Entities\UserRoles::VENDOR)}}">Vendors Login Reports</a>
                    </li>

                    <li @if(isset($active) && $active == 'rate_reports') class="active" @endif>
                        <a href="{{url('/reports/rate')}}">Rating Reports</a>
                    </li>
                    <li @if(isset($active) && $active == 'wedding') class="active" @endif>
                        <a href="{{url('/reports/wedding')}}">wedding Reports</a>
                    </li>
                </ul>
            </li>
        @endif


        {{--translations--}}
        {{--        <li @if(isset($active) && $active === 'translations') class="active" @endif>--}}
        {{--            <a href="{{url('/translations')}}" class="waves-effect">--}}
        {{--                <i class="fa fa-file-word-o"></i>--}}
        {{--                <span> {{trans('admin.translations_title')}} </span>--}}
        {{--            </a>--}}
        {{--        </li>--}}

        {{-- contact messages --}}
        {{--<li @if(isset($active) && $active === 'contact_messages') class="active" @endif>--}}
        {{--<a href="{{url("/contact/messages")}}" class="waves-effect"><i class="fa fa-inbox"></i>--}}
        {{--<span> {{trans('admin.contact_messages_title')}} </span>--}}
        {{--</a>--}}
        {{--</li>--}}


        {{--logout--}}
        <li>
            <a href="{{url("/logout")}}" class="waves-effect"><i class="fa fa-power-off"></i>
                <span> {{trans('admin.logout_title')}} </span>
            </a>
        </li>


    </ul>
    <div class="clearfix"></div>
</div>
