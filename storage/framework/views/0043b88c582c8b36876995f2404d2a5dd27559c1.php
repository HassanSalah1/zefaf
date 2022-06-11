<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="status">Main Category</label>
                            <select id="main_category_id" class="form-control" name="main_category_id">
                                <option value="-1">none</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="status">Sub Category</label>
                            <select required id="category_id" class="form-control" name="category_id">
                            </select>
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name">Name</label>
                            <input required type="text" id="name" class="form-control" name="name"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="email">Email</label>
                            <input required type="email" id="email" class="form-control" name="email"/>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="phone">Phone</label>
                            <input required type="number" id="phone" class="form-control" name="phone"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="password">Password</label>
                            <input required type="password" id="password" class="form-control" name="password"/>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label class="control-label"
                                   for="biography">biography</label>
                            <textarea required id="biography" class="form-control" name="biography"></textarea>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-3">
                            <label class="control-label"
                                   for="price_from">price from</label>
                            <input required type="number" id="price_from" class="form-control" name="price_from"/>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-3">
                            <label class="control-label"
                                   for="price_to">price to</label>
                            <input required type="number" id="price_to" class="form-control" name="price_to"/>
                        </div> <!-- form-group -->

                        

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="image"><?php echo e(trans('admin.image')); ?></label>
                            <div class="media no-margin-top">
                                <div class="media-left">
                                    <a href="<?php echo e(url('/dashboard/images/placeholder.jpg')); ?>" data-popup="lightbox">
                                        <img id="preview" src="<?php echo e(url('/dashboard/images/placeholder.jpg')); ?>"
                                             class="img-rounded img-preview"
                                             style="width: 58px; height: 58px; border-radius: 2px;"
                                             alt="">
                                    </a>
                                </div>

                                <div class="media-body">
                                    <div class="uploader bg-danger" id="uniform-img">
                                        <input type="file" class="file-styled form-data ui-wizard-content" id="image"
                                               name="image" accept="image/*">
                                        <span class="filename"
                                              style="user-select: none;"><?php echo e(trans('admin.no_file_selected')); ?></span>
                                        <span class="action" style="user-select: none;">
                                            <i class="fa fa-plus-square fa-3x icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="country_id">Country</label>
                            <select id="country_id" class="form-control" name="country_id">
                                <option value="-1">none</option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>"><?php echo e($country->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="city_id">City</label>
                            <select required id="city_id" class="form-control" name="city_id">
                            </select>
                        </div> <!-- form-group -->

                    </div>

                    <div class="row">

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="membership_id">Membership</label>
                            <select id="membership_id" class="form-control" name="membership_id">
                                <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($membership->id); ?>"><?php echo e($membership->type); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6" id="duration_div">
                            <label class="control-label"
                                   for="duration">Duration</label>
                            <select id="duration" class="form-control" name="duration">
                                <option value="30">1 Month</option>
                                <option value="60">2 Month</option>
                                <option value="90">3 Month</option>
                                <option value="120">4 Month</option>
                                <option value="150">5 Month</option>
                                <option value="180">6 Month</option>
                                <option value="210">7 Month</option>
                                <option value="240">8 Month</option>
                                <option value="270">9 Month</option>
                                <option value="300">10 Month</option>
                                <option value="330">11 Month</option>
                                <option value="360">12 Month</option>
                            </select>
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6" id="duration2_div" style="display: none;">
                            <label class="control-label"
                                   for="free_duration">Duration</label>
                            <input class="form-control" type="number" min="1"
                                   name="free_duration" id="free_duration"/>
                        </div> <!-- form-group -->

                    </div>

                    <br>

                    <div class="row">

                        <div class="form-group col-md-4 offset-4">
                            <button type="submit"
                                    class="btn btn-primary btn-rounded w-md waves-effect waves-light m-b-5">
                                <?php echo e(trans('admin.save')); ?>

                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url('/dashboard/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(url('/dashboard/js/components/toastr.min.js')); ?>"></script>
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
        let meals = [];
        let cart = [];

        $(function () {
            $('#main_category_id').select2();
            $('#category_id').select2();
            $('#country_id').select2();
            $('#city_id').select2();

            $('#membership_id').select2();
            $('#duration').select2();

            $('#membership_id').on('change', (e) => {
                console.log($('#membership_id').find('option:selected').val())
                if ($('#membership_id').find('option:selected').val() == 4) {
                    $('#duration_div').hide();
                    $('#duration2_div').show();
                }else{
                    $('#duration_div').show();
                    $('#duration2_div').hide();
                }
            });


            $('[data-popup="lightbox"]').fancybox({
                padding: 3,
                width: 560,
                height: 340
            });

            previewImage($('#general-form input[name=image]'));

            $('#general-form').submit(function (e) {
                e.preventDefault();
                sendAjaxRequest(this, '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/vendor/add')); ?>',
                    {
                        error_message: '<?php echo e(trans('admin.general_error_message')); ?>',
                        error_title: '<?php echo e(trans('admin.error_title')); ?>',
                        loader: true,
                        load_page: '<?php echo e(url('vendors')); ?>'
                    });
            });

            $('#main_category_id').on('change', (e) => {
                const category = $('#main_category_id').find('option:selected').val();
                console.log(category);
                let form = new FormData();
                form.append('category_id', category);
                form.append('deleted', 1);
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
                        response.data.forEach((category) => {
                            cityHtml += '<option value="' + category.id + '">'
                                + category.name + '</option>';
                        });
                        $('#city_id').html(cityHtml);
                        $('#city_id').select2();
                    },
                    error: function (response) {
                    }
                });
            });

        });
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(url('/dashboard/css/select2.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('/dashboard/css/select2-bootstrap.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('/dashboard/css/components/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/jquery.loader.css')); ?>" rel="stylesheet"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layers.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>