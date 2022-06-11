<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <form role="form" id="general-form">

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name_ar"><?php echo e(trans('admin.name_arabic')); ?></label>
                            <input required type="text" id="name_ar" name="name_ar"
                                   class="form-control"
                                   placeholder="<?php echo e(trans('admin.name_arabic')); ?>">
                        </div> <!-- form-group -->

                        <div class="form-group col-sm-6">
                            <label class="control-label"
                                   for="name_en"><?php echo e(trans('admin.name_english')); ?></label>
                            <input required type="text" id="name_en" name="name_en"
                                   class="form-control"
                                   placeholder="<?php echo e(trans('admin.name_english')); ?>">
                        </div> <!-- form-group -->
                    </div>

                    <div class="row">
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

                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="category_id"><?php echo e(trans('admin.main_category')); ?></label>
                            <select id="category_id" class="form-control"
                                    data-placeholder="<?php echo e(trans('admin.main_category')); ?>" name="category_id">
                                <option value="">none</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryObj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                    value="<?php echo e($categoryObj->id); ?>"><?php echo e($categoryObj->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row" id="question_type_div" style="display: none;">
                        <div class="form-group col-md-6">
                            <label class="control-label"
                                   for="question_type">Question</label>
                            <select id="question_type" class="form-control" name="question_type">
                                <?php $__currentLoopData = \App\Entities\CategoryQuestionType::getKeys(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($questionType); ?>"><?php echo e(trans('admin.'. $questionType)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <button type="button" onclick="addNewTip()"
                                        class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">
                                    <i class="fa fa-plus-square"></i> <?php echo e(trans('admin.add_tip')); ?>

                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="tips">

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
        let tips = 0;
        $(function () {

            $('#category_id').select2();
            $('#question_type').select2();

            $('#category_id').on('change' , () => {
                let category = $(this).find('option:selected').val();
                if(category){
                    $('#question_type_div').show();
                }else{
                    $('#question_type_div').hide();
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
                sendAjaxRequest(this, '<?php echo e(url( (($locale === 'ar') ? $locale : '') . '/category/add')); ?>',
                    {
                        error_message: '<?php echo e(trans('admin.general_error_message')); ?>',
                        error_title: '<?php echo e(trans('admin.error_title')); ?>',
                        loader: true,
                        load_page: '<?php echo e(url('/categories')); ?>'
                    });
            });
        });

        function addNewTip() {
            let html = '<div id="tip_' + tips + '" class="row">' +
                            '<div class="form-group col-md-6">'+
                                '<input type="text" name="tips_en[]" class="form-control"' +
                                  'placeholder="<?php echo e(trans('admin.tip')); ?> en ' + (tips + 1) + '" />' +
                            '</div>' +
                            '<div class="form-group col-md-6">'+
                            '<input type="text" name="tips_ar[]" class="form-control"' +
                            'placeholder="<?php echo e(trans('admin.tip')); ?> ar ' + (tips + 1) + '" />' +
                            '</div>' +
                            '<div class="form-group col-md-3">' +
                                '<button type="button" onclick="deleteTip(' + tips + ')"' +
                                    'class="btn btn-danger btn-rounded waves-effect waves-light m-b-5">' +
                                    '<i class="fa fa-trash"></i>' +
                                '</button>' +
                            '</div>'+
                        '</div>';
            $('#tips').append(html);
            tips++;
        }

        function deleteTip(tipIndex) {
            $('#tip_' + tipIndex).remove();
            tips --;
            // deletedSizes++;
        }

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <link href="<?php echo e(url('/dashboard/css/select2.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('/dashboard/css/select2-bootstrap.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('/dashboard/css/components/toastr.min.css')); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(url('/dashboard/css/jquery.loader.css')); ?>" rel="stylesheet"/>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layers.partials.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>