<div id="sidebar-menu">
    <ul>
        <li class="text-muted menu-title"></li>

        
        <li <?php if(isset($active) && $active === 'home'): ?> class="active" <?php endif; ?>>
            <a href="<?php echo e(url("/home")); ?>" class="waves-effect"><i class="mdi mdi-view-dashboard"></i>
                <span> <?php echo e(trans('admin.home_title')); ?> </span>
            </a>
        </li>

        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::SETTINGS} == 1 ||
                $permissions->{\App\Entities\PermissionKey::CLIENT_TERMS} == 1 ||
                 $permissions->{\App\Entities\PermissionKey::COUNTRIES} == 1 )))): ?>
            
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-gear"></i>
                    <span> <?php echo e(trans('admin.setting_title')); ?> </span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">

                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        $permissions->{\App\Entities\PermissionKey::CLIENT_TERMS} == 1) )): ?>
                        <li <?php if(isset($active) && $active == 'client_terms'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/client/terms')); ?>"><?php echo e(trans('admin.client_terms_title')); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                   || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                       $permissions->{\App\Entities\PermissionKey::VENDOR_TERMS} == 1) )): ?>
                        <li <?php if(isset($active) && $active == 'vendor_terms'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/vendor/terms')); ?>"><?php echo e(trans('admin.vendor_terms_title')); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                $permissions->{\App\Entities\PermissionKey::MEMBERSHIPS} == 1) )): ?>
                        <li <?php if(isset($active) && $active == 'memberships'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/memberships')); ?>"><?php echo e(trans('admin.memberships_title')); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                    $permissions->{\App\Entities\PermissionKey::COUNTRIES} == 1) )): ?>
                        <li <?php if(isset($active) && $active == 'countries'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/countries')); ?>"><?php echo e(trans('admin.countries_title')); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                $permissions->{\App\Entities\PermissionKey::AREAS} == 1) )): ?>
                        <li <?php if(isset($active) && $active == 'areas'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/areas')); ?>"><?php echo e(trans('admin.areas_title')); ?></a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>
        <?php endif; ?>

        
        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::PERMISSIONS} == 1 ||
                $permissions->{\App\Entities\PermissionKey::EMPLOYEES} == 1 )) )): ?>
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-user-secret"></i>
                    <span> <?php echo e(trans('admin.employees_list_title')); ?> </span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                    $permissions->{\App\Entities\PermissionKey::PERMISSIONS} == 1) )): ?>
                        <li <?php if(isset($active) && $active == 'permissions'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/permissions')); ?>"><?php echo e(trans('admin.permissions_title')); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                    $permissions->{\App\Entities\PermissionKey::EMPLOYEES} == 1 ) )): ?>
                        <li <?php if(isset($active) && $active == 'employees'): ?> class="active" <?php endif; ?>>
                            <a href="<?php echo e(url('/employees')); ?>"><?php echo e(trans('admin.employees_title')); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>


        
        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::CATEGORIES} == 1 )) )): ?>
            
            <li <?php if(isset($active) && $active === 'categories'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/categories")); ?>" class="waves-effect"><i class="fa fa-paragraph"></i>
                    <span> <?php echo e(trans('admin.categories_title')); ?> </span>
                </a>
            </li>
        <?php endif; ?>

        
        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::USERS} == 1 )) )): ?>
            
            <li <?php if(isset($active) && $active === 'users'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/users")); ?>" class="waves-effect"><i class="fa fa-user-circle-o"></i>
                    <span> <?php echo e(trans('admin.users_title')); ?> </span>
                </a>
            </li>
        <?php endif; ?>

        
        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) )): ?>
            

            <li <?php if(isset($active) && $active === 'add_vendor'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/vendor/add")); ?>" class="waves-effect"><i class="fa fa-plus"></i>
                    <span> Add vendor </span>
                </a>
            </li>

            <li <?php if(isset($active) && $active === 'vendors'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/vendors")); ?>" class="waves-effect"><i class="fa fa-users"></i>
                    <span> <?php echo e(trans('admin.vendors_title')); ?> </span>
                </a>
            </li>

            <li <?php if(isset($active) && $active === 'vendors_review'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/vendors/review")); ?>" class="waves-effect"><i class="fa fa-user-secret"></i>
                    <span>
                    <?php echo e(trans('admin.vendors_review_title')); ?>

                    <label class="btn btn-warning btn-rounded" style="padding: 0px 5px;">
                            <?php echo e(\App\Models\User\User::where(['status' => \App\Entities\UserStatus::REVIEW,'role' => \App\Entities\UserRoles::VENDOR])->count()); ?>

                        </label>
                    </span>
                </a>
            </li>
        <?php endif; ?>

        
        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) )): ?>
            
            <li <?php if(isset($active) && $active === 'requests'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/requests")); ?>" class="waves-effect"><i class="fa fa-edit"></i>
                    <span>
                        requests
                        <label class="btn btn-warning btn-rounded" style="padding: 0px 5px;">
                            <?php echo e(\App\Models\User\EditRequest::where(['status' => \App\Entities\EditRequestStatus::PENDING])->count()); ?>

                        </label>
                    </span>
                </a>
            </li>
        <?php endif; ?>

        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                        || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        ($permissions->{\App\Entities\PermissionKey::NOTIFICATIONS} == 1 )) )): ?>
            <li <?php if(isset($active) && $active === 'notifications'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/notifications")); ?>" class="waves-effect"><i class="fa fa-inbox"></i>
                    <span> Users <?php echo e(trans('admin.notifications_title')); ?> </span>
                </a>
            </li>

            <li <?php if(isset($active) && $active === 'vendors_notifications'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url("/notifications/vendors")); ?>" class="waves-effect"><i class="fa fa-inbox"></i>
                    <span> Vendors notifications </span>
                </a>
            </li>

        <?php endif; ?>

        
        <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                $permissions->{\App\Entities\PermissionKey::REPORTS} == 1  ) )): ?>
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bar-chart-o"></i>
                    <span> Reports </span>
                    <span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li <?php if(isset($active) && $active == 'category_reports'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/categories')); ?>">Category Reports</a>
                    </li>

                    <li <?php if(isset($active) && $active == 'vendors_reports'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/vendors')); ?>">Vendors Reports</a>
                    </li>

                    <li <?php if(isset($active) && $active == 'memberships_reports'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/memberships')); ?>">Memberships Reports</a>
                    </li>

                    <li <?php if(isset($active) && $active == 'clogin_reports'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/login?type='.\App\Entities\UserRoles::CUSTOMER)); ?>">Clients Login Reports</a>
                    </li>

                    <li <?php if(isset($active) && $active == 'vlogin_reports'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/login?type='.\App\Entities\UserRoles::VENDOR)); ?>">Vendors Login Reports</a>
                    </li>

                    <li <?php if(isset($active) && $active == 'rate_reports'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/rate')); ?>">Rating Reports</a>
                    </li>
                    <li <?php if(isset($active) && $active == 'wedding'): ?> class="active" <?php endif; ?>>
                        <a href="<?php echo e(url('/reports/wedding')); ?>">wedding Reports</a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>


        
        
        
        
        
        
        

        
        
        
        
        
        


        
        <li>
            <a href="<?php echo e(url("/logout")); ?>" class="waves-effect"><i class="fa fa-power-off"></i>
                <span> <?php echo e(trans('admin.logout_title')); ?> </span>
            </a>
        </li>


    </ul>
    <div class="clearfix"></div>
</div>
