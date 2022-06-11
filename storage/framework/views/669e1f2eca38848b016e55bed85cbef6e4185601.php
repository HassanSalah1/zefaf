<?php $__env->startSection('form_inputs'); ?>
    <div class="row">
        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="name"><?php echo e(trans('admin.name_arabic')); ?></label>
            <input required type="text" id="name_ar" name="name_ar"
                   class="form-control"
                   placeholder="<?php echo e(trans('admin.name_arabic')); ?>">
        </div> <!-- form-group -->

        <div class="form-group col-sm-6">
            <label class="control-label"
                   for="name"><?php echo e(trans('admin.name_english')); ?></label>
            <input required type="text" id="name_en" name="name_en"
                   class="form-control"
                   placeholder="<?php echo e(trans('admin.name_english')); ?>">
        </div> <!-- form-group -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <button id="add_btn" type="button" data-toggle="modal" data-target=".general_modal"
                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                    <i class="fa fa-plus-square"></i> <?php echo e(trans('admin.add_country')); ?>

                </button>
            </div>
        </div>
    </div>
    

    <?php echo $__env->make('admin.layers.partials.table', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.layers.partials.modal', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url('/dashboard/js/components/toastr.min.js')); ?>"></script>
    <!-- Datatables-->
    <script src="<?php echo e(url('/dashboard/js/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/sweet-alert.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/jquery.loader.js')); ?>"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '<?php echo e(csrf_token()); ?>';
        let defaultlogo = '<?php echo e(url('/dashboard/logos/placeholder.jpg')); ?>';
    </script>
    <script src="<?php echo e(url('/dashboard/js/general/utils.js')); ?>"></script>
    <script>

        $(function () {

            addModal({
                title: '<?php echo e(trans('admin.add_country')); ?>',
            });
            onClose();

            loadDataTables('<?php echo e(url( (($locale === 'ar') ? $locale : '') ."/countries/data")); ?>',
                ['name_ar', 'name_en', 'actions'], '',
                {
                    'show': '<?php echo e(trans('admin.show')); ?>',
                    'first': '<?php echo e(trans('admin.first')); ?>',
                    'last': '<?php echo e(trans('admin.last')); ?>',
                    'filter': '<?php echo e(trans('admin.filter')); ?>',
                    'filter_type': '<?php echo e(trans('admin.type_filter')); ?>',
                });

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendModalAjaxRequest(this, '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/country/add')); ?>',
                    '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/country/edit')); ?>', {
                        error_message: '<?php echo e(trans('admin.general_error_message')); ?>',
                        error_title: '<?php echo e(trans('admin.error_title')); ?>',
                        loader: true,
                    });
            });
        });


        function editCountry(item) {
            var id = $(item).attr('id');
            var form = new FormData();
            form.append('id', id);
            $('.modal-title').text('<?php echo e(trans('admin.edit_country')); ?>');
            pub_id = id;
            $.ajax({
                url: '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/country/data')); ?>',
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (response) {
                    $('#general-form input[name=name_ar]').val(response.data.name_ar);
                    $('#general-form input[name=name_en]').val(response.data.name_en);
                    $('.general_modal').modal('toggle');
                    edit = true;
                    add = false;

                },
                error: function () {
                    toastr['error']('<?php echo e(trans('admin.general_error_message')); ?>', '<?php echo e(trans('admin.error_title')); ?>');
                }
            });

        }

        function deleteCountry(item) {
            ban(item, '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/country/delete')); ?>', {
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