<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($judul); ?></title>
    <style>
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            width: 1cm;
            height: auto;
        }
        .title {
            text-align: center;
        }
        .header-row{
            height: 75px;
            text-align: center
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th colspan="7">
                    <div class="header">
                        <div class="title">
                            <h2><?php echo e($judul); ?></h2>
                            <h4><?php echo e(config('app.location')); ?></h4>
                            <p>Tanggal : 
                                <?php if($startDate == $endDate): ?>
                                    <?php echo e(date('d F Y', strtotime($startDate))); ?>

                                <?php else: ?>
                                    <?php echo e(date('d F Y', strtotime($startDate))); ?> s/d <?php echo e(date('d F Y', strtotime($endDate))); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </th>
            </tr>

            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Kode Voucher</th>
                <th>Jenis Kendaraan</th>
                <th>Nomor Polisi</th>
            </tr>
            
        </thead>
        <tbody>
            <?php
            ?>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->tanggal); ?></td>
                    <td><?php echo e($result->tanggal_keluar); ?></td>
                    <td><?php echo e($result->kode_voucher); ?></td>
                    <td><?php echo e($result->jenis_kendaraan); ?></td>
                    <td><?php echo e($result->nopol); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH D:\laragon\www\Intermark\resources\views/exports/reportvoucher_intermark.blade.php ENDPATH**/ ?>