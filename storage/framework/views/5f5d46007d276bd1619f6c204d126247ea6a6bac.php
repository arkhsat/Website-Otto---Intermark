
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Floor')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Floor')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create floor')): ?>
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
           data-url="<?php echo e(route('floor.create')); ?>"
           data-title="<?php echo e(__('Create Floor')); ?>"> <i class="ti-plus mr-5"></i><?php echo e(__('Create Floor')); ?></a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th><?php echo e(__('Title')); ?></th>
                            <th><?php echo e(__('Parking Zone')); ?></th>
                            <th><?php echo e(__('Floor Level')); ?></th>
                            <th><?php echo e(__('Notes')); ?></th>
                            <th><?php echo e(__('Created Date')); ?></th>
                            <?php if(Gate::check('edit floor') ||  Gate::check('delete floor')): ?>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr role="row">
                                <td> <?php echo e($floor->title); ?>   </td>
                                <td> <?php echo e(!empty($floor->zones)?$floor->zones->zone_name:'-'); ?>   </td>
                                <td><?php echo e($floor->floor_level); ?> </td>
                                <td><?php echo e($floor->notes); ?> </td>
                                <td><?php echo e(dateFormat($floor->created_at)); ?> </td>
                                <?php if(Gate::check('edit floor') ||  Gate::check('delete floor')): ?>
                                    <td class="text-right">
                                        <div class="cart-action">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['floor.destroy', $floor->id]]); ?>


                                            <?php if(Gate::check('edit floor') ): ?>
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="md" href="#"
                                                   data-url="<?php echo e(route('floor.edit',$floor->id)); ?>"
                                                   data-title="<?php echo e(__('Edit Floor')); ?>"> <i data-feather="edit"></i></a>
                                            <?php endif; ?>
                                            <?php if( Gate::check('delete floor')): ?>
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Detete')); ?>" href="#"> <i
                                                        data-feather="trash-2"></i></a>
                                            <?php endif; ?>
                                            <?php echo Form::close(); ?>

                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Intermark\resources\views/floor/index.blade.php ENDPATH**/ ?>