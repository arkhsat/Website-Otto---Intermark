<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perpanjangan Member</title>
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

    <h3>Data Perpanjangan Member</h3>
    <table>
        <thead>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Tanggal Bayar</th>
            <th style="width: 20%;">Nama</th>
            <th style="width: 20%;">Perusahaan</th>
            <th style="width: 15%;">Plat Kendaraan</th>
            <th style="width: 10%;">Jenis Kendaraan</th>
            <th style="width: 10%;">Produk</th>
            <th style="width: 10%;">Keterangan</th>
            
        </thead>
        <tbody>
            <?php
            $totalBiaya = 0; 
            ?>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->tanggal); ?></td>
                    <td><?php echo e($result->nama); ?></td>
                    <td><?php echo e($result->perusahaan); ?></td>
                    <td><?php echo e($result->nopol); ?></td>
                    <td><?php echo e($result->jenis_kendaraan); ?></td>
                    <td><?php echo e($result->jenis_produk); ?></td>
                    <td><?php echo e($result->keterangan); ?></td>
                    
                </tr>
                <?php
                    $totalBiaya += $result->biaya;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
        </tbody>
    </table>


    <div class="footer">
        Tanggal Cetak: <?php echo e(date('d F Y')); ?>

    </div>
</body>
</html><?php /**PATH E:\WEB Baru\web-admin-dev\resources\views/PDF/pdfperpanjangmember.blade.php ENDPATH**/ ?>