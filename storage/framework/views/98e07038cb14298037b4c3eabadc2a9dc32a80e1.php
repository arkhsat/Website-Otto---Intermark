

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
                    <form id="hotel-report-form" action="<?php echo e(route('report.pajak.data')); ?>" method="GET">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-2">
                                <?php echo e(Form::label('bulan', __('Month'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::select('bulan', [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ], request('bulan', date('m')), ['class' => 'form-control'])); ?>

                            </div>
                            <div class="col-md-2">
                                <?php echo e(Form::label('tahun', __('Year'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::selectRange('tahun', 2020, date('Y') + 5, request('tahun', date('Y')), ['class' => 'form-control'])); ?>

                            </div>


                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="submit">Process</button>
                            </div>
                        </div>
                    </form>
                    <br>

                    <?php if(!empty($results)): ?>
                        <h4 style="text-align: center;"><?php echo e($reportname); ?></h4>
                        <div style="margin-bottom: 10px;">
                            <a href="<?php echo e(route('report.pajak.print', ['bulan' => request('bulan'), 'tahun' => request('tahun')])); ?>" class="btn btn-primary">Download PDF</a>
                            
                        </div>
                        <table class="display dataTable cell-border">
                            <thead style="text-align: center;">
                                <tr>
                                    <td class="xl66" style="height: 32.0pt; width: 10pt;">No</td>
                                    <td class="xl66" style="width: 35pt;">Tanggal Transaksi</td>
                                    <td class="xl65" style="width: 130pt;">Omset</td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr role="row" style="text-align: center;">
                                        <td><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($result->tanggal_transaksi); ?></td>
                                        <td>Rp <?php echo e(number_format($result->amount,0,',','.')); ?></td>
                                        
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




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\WEB Baru\web-admin-dev\resources\views/report_pajak/index.blade.php ENDPATH**/ ?>