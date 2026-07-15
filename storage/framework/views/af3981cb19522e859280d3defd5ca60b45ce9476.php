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
                <th colspan="5">
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
                <th>Tanggal Keluar</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Total Transaksi</th>
            </tr>
            
        </thead>
        <tbody>
            <?php
                $nomor = 1;
            ?>
            <?php $__currentLoopData = $summaryByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanggal => $sum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td> <?php echo e($nomor ++); ?></td>
                    <td><?php echo e(date('d-m-Y', strtotime($tanggal))); ?></td>
                    <td><?php echo e($sum['mobil']); ?></td>
                    <td><?php echo e($sum['motor']); ?></td>
                    <td><?php echo e($sum['total']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong><?php echo e($totalMobil); ?></strong></td>
                <td><strong><?php echo e($totalMotor); ?></strong></td>
                <td><strong><?php echo e($totalMobil + $totalMotor); ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html><?php /**PATH D:\laragon\www\Intermark\resources\views/exports/reportsummaryhotel.blade.php ENDPATH**/ ?>