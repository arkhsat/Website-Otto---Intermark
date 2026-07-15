<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Close By ON</title>
    <link rel="stylesheet" href="<?php echo e(public_path('pdf.css')); ?>" type="text/css"> 
</head>
<body>
    <div class="header">
        <img src="<?php echo e(public_path('images/Logo Utama.png')); ?>" alt="Logo Utama" class="logo">
        <div class="title">
            <h2><?php echo e($reportname); ?></h2>
            <h4>Intermark Indonesia</h4>
            <p>Tanggal : 
                <?php if($startDate == $endDate): ?>
                    <?php echo e(date('d F Y', strtotime($startDate))); ?>

                <?php else: ?>
                    <?php echo e(date('d F Y', strtotime($startDate))); ?> s/d <?php echo e(date('d F Y', strtotime($endDate))); ?>

                <?php endif; ?>
            </p>
        </div>
    </div>

    <hr>

    <h3>Data Transaksi Hotel Swiss Bell - SBSR</h3>
    <table>
        <thead>
            <th style="width: 5%;">No</th>
            <th style="width: 20%;">Waktu Masuk</th>
            <th style="width: 20%;">Waktu Keluar</th>
            <th style="width: 20%;">Nama</th>
            <th style="width: 10%;">Kendaraan</th>
            <th style="width: 10%;">Nomor Polisi</th>
            <th style="width: 10%;">Kamar</th>
        </thead>
        <tbody>
            <?php
                $totalMobil = 0;
                $totalMotor = 0;
                $summaryByDate = [];
            ?>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->tanggal_masuk); ?></td>
                    <td><?php echo e($result->tanggal_keluar); ?></td>
                    <td><?php echo e($result->nama); ?></td>
                    <td><?php echo e($result->jenis_kendaraan); ?></td>
                    <td><?php echo e($result->nopol); ?></td>
                    <td><?php echo e($result->kamar); ?></td>
                    <?php
                        $summaryByDate = [];
                        foreach ($results as $result) {
                            $tgl = date('Y-m-d', strtotime($result->tanggal_keluar)); 
                            if (!isset($summaryByDate[$tgl])) {
                                $summaryByDate[$tgl] = ['mobil' => 0, 'motor' => 0, 'total' => 0];
                            }
                            if (strtolower($result->jenis_kendaraan) == 'mobil') {
                                $summaryByDate[$tgl]['mobil']++;
                            } elseif (strtolower($result->jenis_kendaraan) == 'motor') {
                                $summaryByDate[$tgl]['motor']++;
                            }
                            $summaryByDate[$tgl]['total']++;
                        }
                        ksort($summaryByDate); 
                    ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <br>
    <h4>Summary Harian Berdasarkan Tanggal Keluar</h4>
    <table>
        <thead>
            <tr>
                <th>Tanggal Keluar</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalMobil = 0;
                $totalMotor = 0;
            ?>
            <?php $__currentLoopData = $summaryByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tanggal => $sum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(date('d-m-Y', strtotime($tanggal))); ?></td>
                    <td><?php echo e($sum['mobil']); ?></td>
                    <td><?php echo e($sum['motor']); ?></td>
                    <td><?php echo e($sum['total']); ?></td>
                    <?php
                        $totalMobil += $sum['mobil'];
                        $totalMotor += $sum['motor'];
                    ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><?php echo e($totalMobil); ?></strong></td>
                <td><strong><?php echo e($totalMotor); ?></strong></td>
                <td><strong><?php echo e($totalMobil + $totalMotor); ?></strong></td>
            </tr>
    </table>


    <div class="footer">
        Tanggal Cetak: <?php echo e(date('d F Y')); ?>

    </div>
</body>
</html><?php /**PATH E:\web-admin-dev\resources\views/pdf/pdfreportSBSR.blade.php ENDPATH**/ ?>