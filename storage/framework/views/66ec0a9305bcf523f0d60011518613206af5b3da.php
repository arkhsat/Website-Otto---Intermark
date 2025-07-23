

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Data Perusahaan')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Data Perusahaan')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create rfid vehicle')): ?>
       
           <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="<?php echo e(route('company.create')); ?>"
           data-title="<?php echo e(__('Tambahkan Perusahaan')); ?>"> <i class="ti-plus mr-5"></i><?php echo e(__('Tambahkan Perusahaan')); ?></a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if(!empty($results) && count($results) > 0): ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><?php echo e(__('No')); ?></th>
                                    <th><?php echo e(__('Nama Perusahaan')); ?></th>
                                    <th><?php echo e(__('Kontak')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Aksi')); ?></th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($result->company_name); ?></td>
                                        <td><?php echo e($result->contact); ?></td>
                                        <td><?php echo e($result->email); ?></td>
                                        <td class="text-right">
                                        <div class="cart-action">   
                                            <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                                        data-url="<?php echo e(route('company.edit',$result->id)); ?>"
                                                        data-title="<?php echo e(__('Edit Company Data')); ?>">Edit</a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center text-muted"><?php echo e(__('No data available for the selected date range.')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Kerja\02. Intermark\Website Parking\parkingsystem\parkingsystem\resources\views/company/index.blade.php ENDPATH**/ ?>