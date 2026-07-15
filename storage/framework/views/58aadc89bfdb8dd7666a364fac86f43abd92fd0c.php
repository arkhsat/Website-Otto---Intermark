
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking Rate')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Parking Rate')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create parking rate')): ?>
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="<?php echo e(route('parking-rate.create')); ?>"
           data-title="<?php echo e(__('Create Parking Rate')); ?>"> <i class="ti-plus mr-5"></i><?php echo e(__('Create Parking Rate')); ?></a>
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
                            <th><?php echo e(__('Vehicle Type')); ?></th>
                            <th><?php echo e(__('Parking Zone')); ?></th>
                            <th><?php echo e(__('Start Date')); ?></th>
                            <th><?php echo e(__('Due Date')); ?></th>
                            <th><?php echo e(__('Fixed Rate')); ?></th>
                            <th><?php echo e(__('Hourly Rate')); ?></th>
                            <?php if(Gate::check('edit parking rate') ||  Gate::check('delete parking rate')): ?>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr role="row">
                                <td> <?php echo e(!empty($rate->types)?$rate->types->title:'-'); ?>   </td>
                                <td> <?php echo e(!empty($rate->zones)?$rate->zones->zone_name:'-'); ?>   </td>
                                <td>
                                    <?php echo e(dateFormat($rate->start_date)); ?>

                                </td>
                                <td>
                                    <?php echo e(dateFormat($rate->due_date)); ?>

                                </td>
                                <td><?php echo e(priceFormat($rate->fix_rate)); ?> </td>
                                <td><?php echo e(priceFormat($rate->hourly_rate)); ?> </td>
                                <?php if(Gate::check('edit parking rate') ||  Gate::check('delete parking rate')): ?>
                                    <td class="text-right">
                                        <div class="cart-action">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['parking-rate.destroy', $rate->id]]); ?>


                                            <?php if(Gate::check('edit parking rate') ): ?>
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                                   data-url="<?php echo e(route('parking-rate.edit',$rate->id)); ?>"
                                                   data-title="<?php echo e(__('Edit Parking Rate')); ?>"> <i data-feather="edit"></i></a>
                                            <?php endif; ?>
                                            <?php if( Gate::check('delete parking rate')): ?>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\web-admin-dev\resources\views/parking_rate/index.blade.php ENDPATH**/ ?>