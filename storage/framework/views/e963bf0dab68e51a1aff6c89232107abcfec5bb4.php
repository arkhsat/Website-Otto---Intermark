
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Guest Type')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Guest Type')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
<a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
   data-url="<?php echo e(route('setting.guest-types.create')); ?>"
   data-title="<?php echo e(__('Create Guest Type')); ?>"> <i class="ti-plus mr-5"></i><?php echo e(__('Create Guest Type')); ?>

</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                            <tr>
                            <th><?php echo e(__('No')); ?></th>
                            <th><?php echo e(__('Guest Type')); ?></th>
                            <th><?php echo e(__('Edit')); ?></th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr role="row">
                                <td><?php echo e($loop->iteration); ?></td>
                                <td> <?php echo e(ucfirst($type->type)); ?>  </td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="<?php echo e(route('setting.guest-types.edit', $type->id)); ?>">
                                        <i class="ti-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Intermark\resources\views/guest_type/index.blade.php ENDPATH**/ ?>