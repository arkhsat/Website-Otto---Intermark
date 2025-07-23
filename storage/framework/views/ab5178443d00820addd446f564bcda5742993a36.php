<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Member Motor Parking')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th><?php echo e(__('ID')); ?></th>
                            <th><?php echo e(__('Transaction No')); ?></th>
                            <th><?php echo e(__('Type')); ?></th>
                           
                            <th><?php echo e(__('Entry')); ?></th>
                            <th><?php echo e(__('Exit')); ?></th>
                            <th><?php echo e(__('Duration')); ?></th>
                            
                            <th><?php echo e(__('Plat No')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Payment By')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $parkings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr role="row">
                                <td> <?php echo e(parkingPrefix().$parking->transactionid); ?></td>
                                <td> <?php echo e($parking->tiketno); ?></td>
                                <td> <?php echo e($parking->vehicleid); ?>  </td>
                                <td> <?php echo e($parking->datetransact); ?> </td>
                                <td> <?php echo e($parking->dateout); ?> </td>
                                <td> <?php echo e($parking->duration); ?> </td>
                                <td> <?php echo e($parking->nopolisi); ?> </td>
                                
                               
                                <td>
                                    <?php if($parking->alreadyout=='x'): ?>
                                        <span class="badge badge-danger">Filled</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Out</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($parking->paymentby!= NULL): ?>
                                        <span class="badge badge-danger"><?php echo e($parking->paymentby); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-success"><?php echo e($parking->paymentby); ?></span>
                                    <?php endif; ?>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/parking/motor_member_list.blade.php ENDPATH**/ ?>