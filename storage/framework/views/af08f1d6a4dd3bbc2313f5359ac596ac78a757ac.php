

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking Report Amount')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Report Transaksi Hotel')); ?></a>
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
                    <form id="hotel-report-form" action="<?php echo e(route('report.voucher.trueblue')); ?>" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <?php echo e(Form::label('entry_date', __('Start Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('entry_date', request('entry_date', date('Y-m-d')), ['class' => 'form-control'])); ?>

                            </div>
                            <div class="col-md-2">
                                <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('end_date', request('end_date', date('Y-m-d')), ['class' => 'form-control'])); ?>

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <h4 style="text-align: center;"><?php echo e($reportname); ?></h4>
                    <div style="margin-bottom: 10px;">
                        <br>
                        <a href="<?php echo e(route('report.voucher.trueblue.pdf', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')])); ?>" class="btn btn-primary">Download PDF</a>
                        <a href="<?php echo e(route('report.voucher.trueblue.excel', ['entry_date' => request('entry_date', date('Y-m-d')), 'end_date' => request('end_date', date('Y-m-d')), 'hotel' => request('hotel')])); ?>" class="btn btn-success">Download Excel</a>
                        <br>
                    </div>
                    <?php if(!empty($results)): ?>
                        <table class="display dataTable cell-border datatbl-advance">
                            <thead style="text-align: center;">
                                <tr>
                                    <td class="xl66" style="height: 32.0pt; width: 65pt;">No</td>
                                    <td class="xl66" style="width: 65pt;">Tanggal Masuk</td>
                                    <td class="xl65" style="width: 130pt;">Tanggal Keluar</td>
                                    <td class="xl65" style="width: 130pt;">Kode Voucher</td>
                                    <td class="xl65" style="width: 130pt;">Jenis Kendaraan</td>
                                    <td class="xl65" style="width: 130pt;">Nomor Polisi</td>
                                    <td class="xl65" style="width: 130pt;">Biaya</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row">
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($result->tanggal); ?></td>
                                        <td><?php echo e($result->tanggal_keluar); ?></td>
                                        <td><?php echo e($result->kode_voucher); ?></td>
                                        <td><?php echo e($result->jenis_kendaraan); ?></td>
                                        <td><?php echo e($result->nopol); ?></td>
                                        <td>Rp <?php echo e($result->biaya); ?></td>
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

<script>

    $(document).ready(function() {
        $('.datatbl-advance').DataTable();
    });

</script>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Kerja\02. Intermark\Website Otto\resources\views/reportvoucher/index-trueblue.blade.php ENDPATH**/ ?>