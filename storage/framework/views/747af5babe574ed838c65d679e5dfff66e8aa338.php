<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Hotel')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Hotel')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
<?php if(!Gate::check('manage hotel')): ?>
<a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="md"
   data-url="<?php echo e(route('hotel.create')); ?>"
   data-title="<?php echo e(__('Create Hotel')); ?>"> <i class="ti-plus mr-5"></i><?php echo e(__('Create Compliment')); ?></a>
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
                            <th><?php echo e(__('Room No')); ?></th>
                            <th><?php echo e(__('Guest Name')); ?></th>
                            <th><?php echo e(__('Plat No')); ?></th>
                            <th><?php echo e(__('UID No')); ?></th>
                            <th><?php echo e(__('Check In')); ?></th>
                            <th><?php echo e(__('Check Out')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th class="text-right"><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(ucfirst($hotel->room_no)); ?> </td>
                               
                                <td> <?php echo e(ucfirst($hotel->guest_name)); ?>   </td>
                                <td> <?php echo e(ucfirst($hotel->plat_no)); ?>   </td>
                                <td> <?php echo e(ucfirst($hotel->uidno)); ?>   </td>
                                <td> <?php echo e(ucfirst($hotel->check_in)); ?>   </td>
                                <td> <?php echo e(ucfirst($hotel->check_out)); ?>   </td>
                                <td> <?php echo e(ucfirst($hotel->status)); ?>   </td>
                                
                                <?php if(Gate::check('edit gate') ||  Gate::check('delete gate')): ?>
                                    <td class="text-right">
                                        <div class="cart-action">
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['gate.destroy', $gate->id]]); ?>


                                            <?php if(Gate::check('edit gate') ): ?>
                                                <a class="text-success customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="md" href="#"
                                                   data-url="<?php echo e(route('gate.edit',$floor->id)); ?>"
                                                   data-title="<?php echo e(__('Edit Gate')); ?>"> <i data-feather="edit"></i></a>
                                            <?php endif; ?>
                                            <?php if( Gate::check('delete gate')): ?>
                                                <a class=" text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Delete')); ?>" href="#"> <i
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/hotel/index.blade.php ENDPATH**/ ?>