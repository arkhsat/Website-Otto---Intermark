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
            <h2><?php echo e($judul); ?></h2>
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

    <h3>Data Transaksi Close By ON</h3>
    <table>
        <thead>
            <th style="width: 5%;">No</th>
            <th style="width: 10%;">ID Transaksi</th>
            <th style="width: 15%;">Nomor Kartu</th>
            <th style="width: 10%;">Kendaraan</th>
            <th style="width: 15%;">Tanggal Masuk</th>
            <th style="width: 15%;">Close ON</th>
            <th style="width: 30%%;">Gambar Kendaraan</th>
        </thead>
        <tbody>
            <?php
            $totalBiaya = 0; 
            ?>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->transactionid); ?></td>
                    <td><?php echo e($result->tiketno); ?></td>
                    <td><?php echo e($result->vehicleid); ?></td>
                    <td><?php echo e($result->datetransact); ?></td>
                    <td><?php echo e($result->dateout); ?></td>
                    <td>
                        <?php if($result->posinid == '1'): ?>
                            <img src="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMLG/'.$result->tiketno.'-'.$result->transactionid.'.jpg')); ?>" width="200px">
                        <?php elseif($result->posinid == '2'): ?>
                            <img src="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMLoading/'.$result->tiketno.'-'.$result->transactionid.'.jpg')); ?>" width="200px">
                        <?php elseif($result->posinid == '3'): ?>
                            <img src="<?php echo e(asset('http://192.168.1.55/sambashare/FotoPMMotor/'.$result->tiketno.'-'.$result->transactionid.'.jpg')); ?>" width="200px">
                        <?php else: ?>
                            <span class="badge badge-danger">No Image</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </tbody>
    </table>


    <div class="footer">
        Tanggal Cetak: <?php echo e(date('d F Y')); ?>

    </div>
</body>
</html><?php /**PATH E:\website-otto\resources\views/PDF/pdfreportcloseON.blade.php ENDPATH**/ ?>