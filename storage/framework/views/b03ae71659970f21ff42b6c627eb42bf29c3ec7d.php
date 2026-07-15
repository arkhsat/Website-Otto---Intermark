

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking Tanda Terima')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Tanda Terima Member History')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        thead th{
            text-align: center;
            background-color: #f4f4f4;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('tanda.terima.history.view')); ?>" method="GET">
                        <div class="row g-3 align-items-end">
                            
                            <div class="form-group col-md-4 item-center">
                                <?php echo e(Form::label('entry_date', __('Choose Month'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::input('month', 'entry_date', request('entry_date', date('Y-m')), ['class' => 'form-control'])); ?>

                            </div>
                          
                            <div class="col-md-4">  
                                <select name="vehicle_no[]" class="form-control select2" multiple data-placeholder="Pilih No Polisi">
                                    <?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Intermark\resources\views/tanda_terima_history/index.blade.php ENDPATH**/ ?>