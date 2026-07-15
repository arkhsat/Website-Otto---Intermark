

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking Report Amount')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Report Summary Amount')); ?></a>
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
                    <form action="<?php echo e(route('report.summary.amount')); ?>" method="GET">
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
                        <a href="<?php echo e(route('report.summary.amount.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))])); ?>" class="btn btn-primary">Download PDF</a>
                        <a href="<?php echo e(route('report.summary.amount.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))])); ?>" class="btn btn-success">Download Excel</a>
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="display dataTable cell-border">
                            <thead>
                                <tr style="height: 16.0pt;">
                                    <th class="xl66" style="height: 32.0pt; width: 65pt;" rowspan="2" width="87" height="42">No</th>
                                    <th class="xl66" style="width: 100pt;" rowspan="2" width="87">Nomor</th>
                                    <th class="xl65" style="width: 80pt;" colspan="3" width="174">Mandiri</th>
                                    <th class="xl65" style="width: 80pt;" colspan="3" width="174">BCA</th>
                                    <th class="xl65" style="width: 80pt;" colspan="3" width="174">BNI</th>
                                    <th class="xl65" style="width: 80pt;" colspan="3" width="174">BRI</th>
                                    <th class="xl65" style="width: 80pt;" colspan="3" width="174">QRIS</th>
                                    <th class="xl65" style="width: 80pt;" rowspan="2" width="174">Total</th>
                                </tr>
                                <tr style="height: 16.0pt;">
                                    <th style="height: 16.0pt;" height="21">Mobil</th>
                                    <th>Motor</th>    
                                    <th>Truck</th>
                                    <th>Mobil</th>
                                    <th>Motor</th>
                                    <th>Truck</th>
                                    <th>Mobil</th>
                                    <th>Motor</th>
                                    <th>Truck</th>
                                    <th>Mobil</th>
                                    <th>Motor</th>
                                    <th>Truck</th>
                                    <th>Mobil</th>
                                    <th>Motor</th>
                                    <th>Truck</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row">
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($result->date); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->Mandiri_Mobil)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->Mandiri_Motor)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->Mandiri_Truck)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BCA_Mobil)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BCA_Motor)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BCA_Truck)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BNI_Mobil)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BNI_Motor)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BNI_Truck)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BRI_Mobil)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BRI_Motor)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->BRI_Truck)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->QRIS_Mobil)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->QRIS_Motor)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->QRIS_Truck)); ?></td>
                                        <td style="text-align: center">Rp <?php echo e(number_format($result->total)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
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




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Intermark\resources\views/reportsummary/reportamount.blade.php ENDPATH**/ ?>