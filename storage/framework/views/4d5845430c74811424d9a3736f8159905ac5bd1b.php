

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Report Close ON Transaction')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Report Close ON Transaction')); ?></a>
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
                    <form action="<?php echo e(route('report.on')); ?>" method="GET">
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('entry_date', __('Start Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                            <?php echo e(Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="submit">Process</button>
                        </div>
                    </form>

                    <?php if(!empty($results)): ?>
                    <div style="margin-bottom: 10px;">
                        <a href="<?php echo e(route('report.on.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))])); ?>" class="btn btn-primary">Download PDF</a>
                        <!-- <a href="<?php echo e(route('report.on.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))])); ?>" class="btn btn-success">Download Excel</a> -->
                    </div>
                    <table class="display dataTable cell-border">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;"><?php echo e(__('ID')); ?></th>
                                <th class="text-center" style="width: 5%;"><?php echo e(__('Transaction No')); ?></th>
                                <th class="text-center"><?php echo e(__('Kendaraan')); ?></th>
                                <th class="text-center"><?php echo e(__('Masuk')); ?></th>
                                <th class="text-center"><?php echo e(__('Close ON')); ?></th>
                                <th class="text-center"><?php echo e(__('Gambar Kendaraan')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr role="row">
                                <td> <?php echo e(parkingPrefix().$parking->transactionid); ?></td>
                                <td> <?php echo e($parking->tiketno); ?></td>
                                <td> <?php echo e($parking->vehicleid); ?>  </td>
                                <td> <?php echo e($parking->datetransact); ?> </td>
                               
                                <td> <?php echo e($parking->dateout); ?> </td>

                                <td>
                                    <?php if($parking->posinid == '1'): ?>
                                        <a href="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMLG/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')); ?>" data-lightbox="parking-<?php echo e($parking->transactionid); ?>" data-title="Vehicle Image">
                                            <img src="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMLG/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')); ?>" 
                                                alt="Vehicle Image" 
                                                style="width: 200px; height: auto; cursor: pointer;"
                                                class="img-thumbnail">
                                        </a>
                                    <?php elseif($parking->posinid == '2'): ?>
                                        <a href="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMLoading/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')); ?>" data-lightbox="parking-<?php echo e($parking->transactionid); ?>" data-title="Vehicle Image">
                                            <img src="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMLoading/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')); ?>" 
                                                alt="Vehicle Image" 
                                                style="width: 200px; height: auto; cursor: pointer;"
                                                class="img-thumbnail">
                                        </a>
                                    <?php elseif($parking->posinid == '3'): ?>
                                        <a href="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMMotor/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')); ?>" data-lightbox="parking-<?php echo e($parking->transactionid); ?>" data-title="Vehicle Image">
                                            <img src="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMMotor/'.$parking->tiketno.'-'.$parking->transactionid.'.jpg')); ?>" 
                                                alt="Vehicle Image" 
                                                style="width: 200px; height: auto; cursor: pointer;"
                                                class="img-thumbnail">
                                        </a>
                                    <?php else: ?>
                                        <span class="badge badge-danger">No Image</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p><?php echo e(__('No data available for the selected date range.')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

$(document).ready(function() {
    $('.datatbl-advance').DataTable();
});




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\web-admin-dev\resources\views/reporton/index.blade.php ENDPATH**/ ?>