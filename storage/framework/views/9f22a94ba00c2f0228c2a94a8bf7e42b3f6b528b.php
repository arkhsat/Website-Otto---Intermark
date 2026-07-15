

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking Report Amount')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Report Edit Data Member')); ?></a>
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
                    <form action="<?php echo e(route('reportmember.nonpayment')); ?>" method="GET">
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
                        <a href="<?php echo e(route('reportmember.nonpayment.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))])); ?>" class="btn btn-primary">Download PDF</a>
                        <a href="<?php echo e(route('reportmember.nonpayment.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d'))])); ?>" class="btn btn-success">Download Excel</a>
                    </div>

                    <table id="data" class="display dataTable cell-border">
                        <thead>
                            <thead>
                                <td class="xl66" style="height: 32.0pt; width: 65pt;">No</td>
                                <td class="xl66" style="width: 65pt;">Tanggal Edit</td>
                                <td class="xl65" style="width: 130pt;">Nama</td>
                                <td class="xl65" style="width: 130pt;">Perusahaan</td>
                                <td class="xl65" style="width: 130pt;">Plat Kendaraan</td>
                                <td class="xl65" style="width: 130pt;">Jenis Kendaraan</td>
                                <td class="xl65" style="width: 130pt;">Data Sebelum</td>
                                <td class="xl65" style="width: 130pt;">Data Sesudah</td>
                                <td class="xl65" style="width: 130pt;">Keterangan</td>
                                
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr role="row">
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($result->tanggal); ?></td>
                                    <td><?php echo e($result->nama); ?></td>
                                    <td><?php echo e($result->perusahaan); ?></td>
                                    <td><?php echo e($result->nopol); ?></td>
                                    <td><?php echo e($result->jenis_kendaraan); ?></td>
                                    <td><?php echo e($result->data_sebelum); ?></td>
                                    <td><?php echo e($result->data_update); ?></td>
                                    <td><?php echo e($result->keterangan); ?></td>
                                    
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\web-admin-dev\resources\views/reportmember/reportmembernonpayment.blade.php ENDPATH**/ ?>