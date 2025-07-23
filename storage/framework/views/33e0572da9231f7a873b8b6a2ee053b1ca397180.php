<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking Slot')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Parking Slot')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create parking slot')): ?>
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="<?php echo e(route('parking-slot.create')); ?>"
           data-title="<?php echo e(__('Create Parking Slot')); ?>"> <i class="ti-plus mr-5"></i><?php echo e(__('Create Parking Slot')); ?></a>
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
                            <th><?php echo e(__('Vehicle Type')); ?></th>
                            <th><?php echo e(__('Parking Floor')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Notes')); ?></th>
                            <?php if(Gate::check('edit parking slot') ||  Gate::check('delete parking slot')): ?>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr role="row">
                                <td><?php echo e($slot->title); ?></td>
                                <td> <?php echo e(!empty($slot->zones)?$slot->zones->zone_name:'-'); ?>   </td>
                                <td> <?php echo e(!empty($slot->types)?$slot->types->title:'-'); ?>   </td>
                                <td> <?php echo e(!empty($slot->floors)?$slot->floors->title:'-'); ?>   </td>
                                <td>
                                    <?php if($slot->is_available==1): ?>
                                        <span class="badge badge-success"><?php echo e(__('Available')); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><?php echo e(__('Occupied')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($slot->notes); ?> </td>
                                <?php if(Gate::check('edit parking slot') ||  Gate::check('delete parking slot')): ?>
                                    <td class="text-right">
                                        <div class="cart-action">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['parking-slot.destroy', $slot->id]]); ?>


                                            <?php if(Gate::check('edit parking slot') ): ?>
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                                   data-url="<?php echo e(route('parking-slot.edit',$slot->id)); ?>"
                                                   data-title="<?php echo e(__('Edit Parking Slot')); ?>"> <i data-feather="edit"></i></a>
                                            <?php endif; ?>
                                            <?php if( Gate::check('delete parking slot')): ?>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Kerja\02. Intermark\Website Parking\parkingsystem\parkingsystem\resources\views/parking_slot/index.blade.php ENDPATH**/ ?>