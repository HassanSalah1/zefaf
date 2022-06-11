<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <a type="button" href="<?php echo e(url('/category/add')); ?>"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                        <i class="fa fa-plus-square"></i> <?php echo e(trans('admin.add_category')); ?>

                </a>
            </div>
        </div>
    </div>
    

    <?php echo $__env->make('admin.layers.partials.table', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url('/dashboard/js/components/toastr.min.js')); ?>"></script>
    <!-- Datatables-->
    <script src="<?php echo e(url('/dashboard/js/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/sweet-alert.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/jquery.loader.js')); ?>"></script>
    <script>
        var csrf_token = '<?php echo e(csrf_token()); ?>';
        let defaultlogo = '<?php echo e(url('/dashboard/logos/placeholder.jpg')); ?>';
    </script>
    <script src="<?php echo e(url('/dashboard/js/general/utils.js')); ?>"></script>
    <script>

        $(function () {

            loadDataTables('<?php echo e(url( (($locale === 'ar') ? $locale : '') ."/categories/data")); ?>',
                ['name_ar', 'name_en' , 'image'  , 'subcategories_count', 'actions'], '',
                {
                    'show': '<?php echo e(trans('admin.show')); ?>',
                    'first': '<?php echo e(trans('admin.first')); ?>',
                    'last': '<?php echo e(trans('admin.last')); ?>',
                    'filter': '<?php echo e(trans('admin.filter')); ?>',
                    'filter_type': '<?php echo e(trans('admin.type_filter')); ?>',
                });
        });


        function deleteCategory(item) {
            ban(item, '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/category/delete')); ?>', {
                error_message: '<?php echo e(trans('admin.general_error_message')); ?>',
                error_title: '<?php echo e(trans('admin.error_title')); ?>',
                ban_title: "<?php echo e(trans('admin.delete_action')); ?>",
                ban_message: "<?php echo e(trans('admin.delete_message')); ?>",
                inactivate: "<?php echo e(trans('admin.delete_action')); ?>",
                cancel: "<?php echo e(trans('admin.cancel')); ?>"
            });
        }

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/components/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/sweet-alert.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/jquery.loader.css')); ?>" rel="stylesheet"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layers.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>