<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">

            <table id="datatable" class="table table-bordered">
                <thead>
                <tr>
                    <?php $__currentLoopData = $debatable_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <th>
                            <?php echo e($column); ?>

                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
                </thead>

                <tbody>

                </tbody>
            </table>
        </div>
    </div><!-- end col -->
</div>