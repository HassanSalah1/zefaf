<?php $__env->startSection('content'); ?>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status">Main Category</label>
                        <select id="main_category_id" class="form-control" name="main_category_id">
                            <option value="-1">none</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status">Sub Category</label>
                        <select id="category_id" class="form-control" name="category_id">
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="from">From</label>
                        <input class="form-control" type="date" name="from" id="from">
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="to">To</label>
                        <input class="form-control" type="date" name="to" id="to">
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <button class="btn btn-warning btn-rounded" style="margin-top: 27px;"
                                onclick="search()">
                            Search
                        </button>
                    </div>

                </div>
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
    <script src="<?php echo e(url('/dashboard/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script src="<?php echo e(url('/dashboard/js/sweet-alert.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/fancybox.min.js')); ?>"></script>
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

            $('#category_id').select2();
            $('#main_category_id').select2();

            $('#main_category_id').on('change', (e) => {
                const category = $('#main_category_id').find('option:selected').val();
                console.log(category);
                let form = new FormData();
                form.append('category_id', category);

                $.ajax({
                    url: '<?php echo e(url( (($locale === 'ar') ? $locale : '') . "/vendors/get/categories")); ?>',
                    method: 'post',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'},
                    success: function (response) {
                        let categoryHtml = '<option value="-1">none</option>';
                        response.data.forEach((category) => {
                            categoryHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#category_id').html(categoryHtml);
                        $('#category_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

            search();
        });

        function search() {
            let lang = {
                'show': '<?php echo e(trans('admin.show')); ?>',
                'first': '<?php echo e(trans('admin.first')); ?>',
                'last': '<?php echo e(trans('admin.last')); ?>',
                'filter': '<?php echo e(trans('admin.filter')); ?>',
                'filter_type': '<?php echo e(trans('admin.type_filter')); ?>',
                'export': true
            };
            let keys = ['membership', 'vendors_count'];
            let fromDate = $('#from').val();
            let toDate = $('#to').val();
            let category = $('#category_id').find('option:selected').val();
            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            let query = '';

            if (fromDate) {
                query += 'from=' + fromDate + '&';
            }
            if (toDate) {
                query += 'to=' + toDate + '&';
            }
            if (category) {
                query += 'category_id=' + category;
            }

            let url = '<?php echo e(url( (($locale === 'ar') ? $locale : '') . "/reports/memberships/data")); ?>';
            loadDataTables(url + '?' + query, keys, '', lang);
        }

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/components/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/sweet-alert.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/jquery.loader.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(url('/dashboard/css/select2.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('/dashboard/css/select2-bootstrap.css')); ?>" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layers.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>