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
                <th colspan="8">
                    <div class="header">
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
                </th>
            </tr>

            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>Nama</th>
                <th>Perusahaan</th>
                <th>Plat Nomor</th>
                <th>Jenis Kendaraan</th>
                <th>Produk</th>
                <th>Keterangan</th>
                
            </tr>
            
        </thead>
        <tbody>
            <?php
            $totalBiaya = 0; 
            ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
</body>
</html><?php /**PATH E:\website-otto\resources\views/exports/reportmemberperpanjang.blade.php ENDPATH**/ ?>