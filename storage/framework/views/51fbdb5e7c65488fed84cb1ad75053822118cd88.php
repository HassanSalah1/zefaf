<!DOCTYPE html>
<html <?php if($locale === 'ar'): ?> dir="rtl" <?php else: ?> dir="ltr" <?php endif; ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Amgen 350 Care CMS">
    <meta name="author" content="Amgen 350 Care">

    <link rel="shortcut icon" href="<?php echo e(url('/dashboard/images/users/logo@2x.png')); ?>">

    <title><?php echo e($title); ?></title>

    <link href="<?php echo e(url('/dashboard/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/icons.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php if($locale === 'en'): ?>
        <link href="<?php echo e(url('/dashboard/css/rtl/style.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('/dashboard/css/custom/styles_en.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php else: ?>
        <link href="<?php echo e(url('/dashboard/css/ltr/style.css')); ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e(url('/dashboard/css/custom/styles_ar.css')); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>

    <style>
        .logo {
            color: #fff!important;
        }

        .wrapper-page {
            width: 40%;
        }

        .checkbox-custom {
            float: right;
        }

        #showPassword{
            position: relative;
            top: -37px;
            float: left;
        }

        .checkbox-custom input[type="checkbox"]:checked + label::after {
            background: #70C8CE!important;
        }

    </style>

    <script src="<?php echo e(url('/dashboard/js/modernizr.min.js')); ?>"></script>

</head>
<body>
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center">
        <a class="logo"><span><?php echo e(trans('admin.login_title')); ?></span></a>
    </div>
    <!-- start card-box-->
    <div class="m-t-40 card-box">
        <div class="text-center">
            <img src="<?php echo e(url('/dashboard/images/users/logo@2x.png')); ?>" style="width: 100px;">
            <h4 class="text-uppercase font-bold m-b-0">
                <?php echo e(trans('admin.sign_in')); ?>

            </h4>
        </div>
        <div class="p-20">

            <form class="form-horizontal m-t-20" id="loginForm">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <div class="col-xs-12">
                        <span id="generalError" class="text-danger"></span>
                        <input class="form-control" name="email" type="email" required=""
                               placeholder="<?php echo e(trans('admin.email')); ?>">
                        <span id="error" class="text-danger"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" required=""
                               placeholder="<?php echo e(trans('admin.password')); ?>">
                        <a class="btn btn-primary" id="showPassword">
                            <i class="fa fa-eye"></i>
                        </a>











                        <span id="passwordError" class="text-danger"></span>
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-6">
                        <div class="checkbox checkbox-custom">
                            <input id="checkbox-signup" type="checkbox" value="remember" name="remember">
                            <label for="checkbox-signup">
                                <?php echo e(trans('admin.remember_me')); ?>

                            </label>
                        </div>
                    </div>





                </div>
                <span id="authError" class="text-danger"></span>
                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">
                            <?php echo e(trans('admin.login')); ?>

                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- end card-box-->
</div>
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
<!-- App js -->
<script src="<?php echo e(url('/dashboard/js/jquery.core.js')); ?>"></script>
<script src="<?php echo e(url('/dashboard/js/jquery.app.js')); ?>"></script>

<script>
    $(function () {
        //login
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            let form = new FormData(this);
            $.ajax({
                url: '<?php echo e(url( (($locale === 'ar') ? $locale : '') ."/login/process")); ?>',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'},
                success: function (response) {
                    if (response.code === 1)
                        window.location = '<?php echo e(url('/home?first_time=1')); ?>';
                    else if (response.code === 2)
                        $('#authError').text(response.message);
                    else {
                        $('#authError').text('<?php echo e(trans('admin.general_error_message')); ?>')
                    }
                },
                error: function (response) {
                    if (response.status == 403) {
                        $('#authError').text(response.responseJSON.message);
                    } else {
                        $('#authError').text('<?php echo e(trans('admin.general_error_message')); ?>');
                    }
                }
            });//ajax request
        });//login function

        $('#showPassword').on('click', function () {
            const password = $('#loginForm input[type=password]');
            const text = $('#loginForm input[type=text]');
            const iTag = $('#showPassword').find('i');
            console.log(password.attr('type'))
            if (password.attr('type') === 'password') {
                password.attr('type', 'text');
                iTag.removeClass('fa-eye');
                iTag.addClass('fa-eye-slash');
            } else if (text.attr('type') === 'text') {
                text.attr('type', 'password');
                iTag.removeClass('fa-eye-slash');
                iTag.addClass('fa-eye');
            }
        });

    });//ready function
</script>

</body>
</html>
