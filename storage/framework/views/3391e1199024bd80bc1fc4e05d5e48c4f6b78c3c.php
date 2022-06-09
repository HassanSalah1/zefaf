<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Zefaf CMS">
    <meta name="author" content="Zefaf">

    <link rel="shortcut icon" href="<?php echo e(url('/dashboard/images/users/logo@2x.png')); ?>">

    <title><?php echo e($title); ?></title>


<?php echo $__env->yieldContent('style'); ?>
<!-- App css -->
    <link href="<?php echo e(url('/dashboard/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/icons.css')); ?>" rel="stylesheet" type="text/css"/>

    <?php if($locale === 'ar' || $locale === 'ur'): ?>
        <link href="<?php echo e(url('/dashboard/css/rtl/style.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('/dashboard/css/custom/styles_ar.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php else: ?>
        <link href="<?php echo e(url('/dashboard/css/ltr/style.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('/dashboard/css/custom/styles_en.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>

    <script src="<?php echo e(url('/dashboard/js/modernizr.min.js')); ?>"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-app.js"></script>



    <script src="https://www.gstatic.com/firebasejs/8.2.5/firebase-messaging.js"></script>













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
                        <h4 class="page-title"><?php echo e($title); ?></h4>
                    </li>
                </ul>

                <nav class="navbar-custom">

                    <ul class="list-unstyled topbar-right-menu float-right mb-0">

                        <li>
                            <!-- Notification -->
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
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
                        src="<?php echo e(url('/dashboard/images/users/logo@2x.png')); ?>"
                        alt="user-img" title=" <?php if(isset($user) && $user): ?> <?php echo e($user->name); ?> <?php else: ?> Admin <?php endif; ?> "
                        class="rounded-circle img-thumbnail img-responsive">
                    <div class="user-status online"><i class="mdi mdi-adjust"></i></div>
                </div>
                <h5><a href="#"> <?php if(isset($user) && $user): ?> <?php echo e($user->name); ?> <?php else: ?> Admin <?php endif; ?> </a></h5>
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="<?php echo e(url('/profile/update')); ?>">
                            <i class="fa fa-edit"></i>
                        </a>
                    </li>






                    <li class="list-inline-item">
                        <a href="<?php echo e(url("/logout")); ?>" class="text-custom">
                            <i class="mdi mdi-power"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End User -->

            <!--- Sidemenu -->
        <?php echo $__env->make('admin.layers.partials.side_bare', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                <?php echo $__env->yieldContent('content'); ?>
            </div> <!-- container -->
        </div> <!-- content -->

        <footer class="footer text-right">
            <?php echo e(date('Y')); ?> © Copy Rights reserved for <a class="rights"
                                                        href="https://milestone-apps.com/">milestone-apps</a>
        </footer>

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


    

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="<?php echo e(url('/dashboard/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/popper.min.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/detect.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/fastclick.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/jquery.blockUI.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/waves.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/jquery.nicescroll.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/jquery.slimscroll.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/jquery.scrollTo.min.js')); ?>"></script>
<!-- Dashboard init -->

<script>
    var baseNotificationLink = '<?php echo e(url('/')); ?>';
</script>









<!-- App js -->
<script src="<?php echo e(url('/dashboard/js/jquery.core.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/jquery.app.js')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>
</body>

</html>
