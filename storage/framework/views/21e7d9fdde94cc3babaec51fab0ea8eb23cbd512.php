<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="status"><?php echo e(trans('admin.status')); ?></label>
                        <select id="status" class="form-control" name="status">
                            <option value="all">all</option>
                            <?php $__currentLoopData = \App\Entities\UserStatus::getKeys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusObj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if(isset($status) && $status === $statusObj): ?> selected <?php endif; ?>
                                value="<?php echo e($statusObj); ?>">
                                    <?php if($statusObj === \App\Entities\UserStatus::BLOCKED): ?>
                                        Inactive
                                    <?php elseif($statusObj === \App\Entities\UserStatus::REVIEW): ?>
                                        In review
                                    <?php else: ?>
                                        <?php echo e($statusObj); ?>

                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div> <!-- form-group -->

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
                               for="country_id">Country</label>
                        <select id="country_id" class="form-control" name="country_id">
                            <option value="-1">none</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <label class="control-label"
                               for="city_id">City</label>
                        <select id="city_id" class="form-control" name="city_id">
                        </select>
                    </div> <!-- form-group -->

                    <div class="form-group col-sm-3">
                        <button class="btn btn-warning btn-rounded" style="margin-top: 22px;" onclick="search()">
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
    <script src="<?php echo e(url('/dashboard/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/dashboard/js/components/toastr.min.js')); ?>"></script>
    <!-- Datatables-->
    <script src="<?php echo e(url('/dashboard/js/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script src="<?php echo e(url('/dashboard/js/sweet-alert.min.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/jquery.loader.js')); ?>"></script>
    <script src="<?php echo e(url('/dashboard/js/fancybox.min.js')); ?>"></script>
    <script>
        var edit = false;
        var add = false;
        var pub_id;
        var csrf_token = '<?php echo e(csrf_token()); ?>';
    </script>
    <script src="<?php echo e(url('/dashboard/js/general/utils.js')); ?>"></script>
    <script>

        $(function () {

            $('#status').select2();
            $('#category_id').select2();
            $('#main_category_id').select2();

            $('#country_id').select2();
            $('#city_id').select2();

            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

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

            $('#country_id').on('change', (e) => {
                const country = $('#country_id').find('option:selected').val();
                let form = new FormData();
                form.append('country_id', country);

                $.ajax({
                    url: '<?php echo e(url( (($locale === 'ar') ? $locale : '') . "/countries/get/cities")); ?>',
                    method: 'post',
                    data: form,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'},
                    success: function (response) {
                        let cityHtml = '<option value="-1">none</option>';
                        response.data.forEach((city) => {
                            cityHtml += '<option value="' + city.id + '">'
                                + city.name + '</option>';
                        });
                        $('#city_id').html(cityHtml);
                        $('#city_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

            searchVendors('<?php echo e(url( (($locale === 'ar') ? $locale : '') . "/vendors/data")); ?>', {
                'show': '<?php echo e(trans('admin.show')); ?>',
                'first': '<?php echo e(trans('admin.first')); ?>',
                'last': '<?php echo e(trans('admin.last')); ?>',
                'filter': '<?php echo e(trans('admin.filter')); ?>',
                'filter_type': '<?php echo e(trans('admin.type_filter')); ?>',
                export: true
            });
        });

        function searchVendors(url, lang) {
            let keys = [
                {
                    data: 'name',
                    name: 'name',
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    searchable: true
                },
                {
                    data: 'type',
                    name: 'memberships.type',
                    searchable: true
                },
                {
                    data: 'membership_duration',
                    name: 'membership_duration',
                    searchable: false
                },
                {
                    data: 'end_membership_date',
                    name: 'end_membership_date',
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false
                },
            ];
            let status = $('#status').find('option:selected').val();
            loadDataTablesKeys(url + '?searchStatus=' + status, keys, '', lang);
        }

        function search() {
            let lang = {
                'show': '<?php echo e(trans('admin.show')); ?>',
                'first': '<?php echo e(trans('admin.first')); ?>',
                'last': '<?php echo e(trans('admin.last')); ?>',
                'filter': '<?php echo e(trans('admin.filter')); ?>',
                'filter_type': '<?php echo e(trans('admin.type_filter')); ?>',
                export: true
            };
            let keys = [
                {
                    data: 'name',
                    name: 'name',
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email',
                    searchable: true
                },
                {
                    data: 'type',
                    name: 'memberships.type',
                    searchable: true
                },
                {
                    data: 'membership_duration',
                    name: 'membership_duration',
                    searchable: false
                },
                {
                    data: 'end_membership_date',
                    name: 'end_membership_date',
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false
                },
            ];
            let status = $('#status').find('option:selected').val();
            let category_id = $('#category_id').find('option:selected').val();
            let city_id = $('#city_id').find('option:selected').val();

            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }
            let query = '';

            if (status) {
                query += 'searchStatus=' + status + '&';
            }
            if (category_id) {
                query += 'category_id=' + category_id + '&';
            }
            if (city_id) {
                query += 'city_id=' + city_id;
            }
            let url = '<?php echo e(url( (($locale === 'ar') ? $locale : '') . "/vendors/data")); ?>';
            loadDataTablesKeys(url + '?' + query, keys, '', lang);
        }

        function activeVendor(item) {
            ban(item, '<?php echo e(url((($locale === 'ar') ? $locale : '') . '/vendor/change')); ?>', {
                error_message: '<?php echo e(trans('admin.error_message')); ?>',
                error_title: '<?php echo e(trans('admin.error_title')); ?>',
                ban_title: "<?php echo e(trans('admin.activate_title')); ?>",
                ban_message: "<?php echo e(trans('admin.activate_message')); ?>",
                inactivate: "<?php echo e(trans('admin.activate_action')); ?>",
                cancel: "<?php echo e(trans('admin.cancel')); ?>",
                status: "<?php echo e(\App\Entities\UserStatus::ACTIVE); ?>"
            });
        }

        function approveVendor(item) {
            ban(item, '<?php echo e(url((($locale === 'ar') ? $locale : '') . '/vendor/change')); ?>', {
                error_message: '<?php echo e(trans('admin.error_message')); ?>',
                error_title: '<?php echo e(trans('admin.error_title')); ?>',
                ban_title: "<?php echo e(trans('admin.approve_action')); ?>",
                ban_message: "<?php echo e(trans('admin.approve_message')); ?>",
                inactivate: "<?php echo e(trans('admin.approve_action')); ?>",
                cancel: "<?php echo e(trans('admin.cancel')); ?>",
                status: "<?php echo e(\App\Entities\UserStatus::ACTIVE); ?>"
            });
        }

        function verifyAccount(item) {
            ban(item, '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/user/verify')); ?>', {
                error_message: '<?php echo e(trans('admin.general_error_message')); ?>',
                error_title: '<?php echo e(trans('admin.error_title')); ?>',
                ban_title: "<?php echo e(trans('admin.verify_action')); ?>",
                ban_message: "<?php echo e(trans('admin.verify_message')); ?>",
                inactivate: "<?php echo e(trans('admin.verify_action')); ?>",
                cancel: "<?php echo e(trans('admin.cancel')); ?>",
            });
        }

        function blockVendor(item) {
            ban(item, '<?php echo e(url((($locale === 'ar') ? $locale : '') . '/vendor/change')); ?>', {
                error_message: '<?php echo e(trans('admin.error_message')); ?>',
                error_title: '<?php echo e(trans('admin.error_title')); ?>',
                ban_title: "<?php echo e(trans('admin.ban_title')); ?>",
                ban_message: "<?php echo e(trans('admin.ban_message')); ?>",
                inactivate: "<?php echo e(trans('admin.inactive_action')); ?>",
                cancel: "<?php echo e(trans('admin.cancel')); ?>",
                status: "<?php echo e(\App\Entities\UserStatus::BLOCKED); ?>",
            });
        }

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(url('/dashboard/css/select2.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('/dashboard/css/select2-bootstrap.css')); ?>" rel="stylesheet" type="text/css">

    <link href="<?php echo e(url('/dashboard/css/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/components/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/sweet-alert.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/jquery.loader.css')); ?>" rel="stylesheet"/>

    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layers.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>