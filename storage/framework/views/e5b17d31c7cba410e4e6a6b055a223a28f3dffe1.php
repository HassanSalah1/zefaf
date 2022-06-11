<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="panel panel-default" data-panel-control data-sortable="true">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?php echo e(trans('admin.statistics')); ?>

                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="row">

                            <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                        || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        ($permissions->{\App\Entities\PermissionKey::USERS} == 1 )) )): ?>
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-primary"
                                       href="<?php echo e(url('/users')); ?>">
                                        <span class="number counter"><?php echo e($all_clients); ?></span>
                                        <span class="name">All Users</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                                <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                    || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                    ($permissions->{\App\Entities\PermissionKey::USERS} == 1 )) )): ?>
                                    <div class="col-md-3">
                                        <a class="dashboard-stat bg-warning"
                                           href="#">
                                            <span class="number counter"><?php echo e($partner_clients); ?></span>
                                            <span class="name">All Users With Partner Name</span>
                                        </a>
                                    </div>
                                <?php endif; ?>

                            <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                        || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                        ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) )): ?>
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-inverse"
                                       href="<?php echo e(url('/vendors')); ?>">
                                        <span class="number counter"><?php echo e($all_vendors); ?></span>
                                        <span class="name">All Vendors</span>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-success"
                                       href="<?php echo e(url('/vendors?status='.\App\Entities\UserStatus::ACTIVE)); ?>">
                                        <span class="number counter"><?php echo e($active_vendors); ?></span>
                                        <span class="name">Active Vendors</span>
                                    </a>
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="row">
                            <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                                                   || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                                                   ($permissions->{\App\Entities\PermissionKey::VENDORS} == 1 )) )): ?>

                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-warning"
                                       href="<?php echo e(url('/vendors?status='.\App\Entities\UserStatus::REVIEW)); ?>">
                                        <span class="number counter"><?php echo e($pending_vendors); ?></span>
                                        <span class="name">In review Vendors</span>
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-danger"
                                       href="<?php echo e(url('/vendors?status='.\App\Entities\UserStatus::BLOCKED)); ?>">
                                        <span class="number counter"><?php echo e($blocked_vendors); ?></span>
                                        <span class="name">Inactive Vendors</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                       || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                       ($permissions->{\App\Entities\PermissionKey::CATEGORIES} == 1 )) )): ?>
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-success"
                                       href="<?php echo e(url('/categories')); ?>">
                                        <span class="number counter"><?php echo e($categories); ?></span>
                                        <span class="name">Categories</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if($user && ($user->role === \App\Entities\UserRoles::ADMIN
                   || ($user->role === \App\Entities\UserRoles::EMPLOYEE &&
                   ($permissions->{\App\Entities\PermissionKey::EMPLOYEES} == 1 )) )): ?>
                                <div class="col-md-3">
                                    <a class="dashboard-stat bg-inverse"
                                       href="<?php echo e(url('/employees')); ?>">
                                        <span class="number counter"><?php echo e($employees); ?></span>
                                        <span class="name">employees</span>
                                    </a>
                                </div>
                            <?php endif; ?>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>

    <script src="<?php echo e(url('/dashboard/js/waypoints/waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/jquery.counterup.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/components/toastr.min.js')); ?>"></script>
    <script>
        $(function () {
            // Counter for dashboard stats
            $('.counter').counterUp({
                delay: 10,
                time: 500
            });

            <?php if(isset($first_time) && $first_time == true): ?>
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
            toastr["success"]('<?php echo e(trans('admin.welcome_message')); ?>', '<?php echo e(trans('admin.welcome_title')); ?>');
            <?php endif; ?>

        })
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(url('/dashboard/css/components/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layers.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>