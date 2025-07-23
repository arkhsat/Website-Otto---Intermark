<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Harian</title>
    <link rel="stylesheet" href="<?php echo e(public_path('pdf.css')); ?>" type="text/css">
    <style>
        .landscape {
            size: 'A4 landscape';
        }
    </style>
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

    <h3>Data Transaksi per Metode Pembayaran</h3>
    <table>
        <thead>
            <tr>
                <th class="xl66" style="width: 20pt;" rowspan="2" width="20">No</th>
                <th class="xl66" style="width: 65pt;" rowspan="2" width="87">Tanggal</th>
                <th class="xl65" style="width: 130pt;" colspan="2" width="150">Mandiri</th>
                <th class="xl65" style="width: 130pt;" colspan="2" width="150">BCA</th>
                <th class="xl65" style="width: 130pt;" colspan="2" width="150">BNI</th>
                <th class="xl65" style="width: 130pt;" colspan="2" width="150">BRI</th>
                <th class="xl65" style="width: 65pt;" rowspan="2" width="75">TOTAL</th>
            </tr>
            <tr>
                <th>Mobil</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Mobil</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $totalMandiriMobil = 0;
                $totalMandiriMotor = 0;
                $totalBCAMobil = 0;
                $totalBCAMotor = 0;
                $totalBNIMobil = 0;
                $totalBNIMotor = 0;
                $totalBRIMobil = 0;
                $totalBRIMotor = 0;
            ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->date); ?></td>
                    <td align="right"><?php echo e(number_format($result->Mandiri_Mobil)); ?></td>
                    <td align="right"><?php echo e(number_format($result->Mandiri_Motor)); ?></td>
                    <td align="right"><?php echo e(number_format($result->BCA_Mobil)); ?></td>
                    <td align="right"><?php echo e(number_format($result->BCA_Motor)); ?></td>
                    <td align="right"><?php echo e(number_format($result->BNI_Mobil)); ?></td>
                    <td align="right"><?php echo e(number_format($result->BNI_Motor)); ?></td>
                    <td align="right"><?php echo e(number_format($result->BRI_Mobil)); ?></td>
                    <td align="right"><?php echo e(number_format($result->BRI_Motor)); ?></td>
                    <td align="right"><?php echo e(number_format($result->total)); ?></td>
                    <?php
                        $total += $result->total;
                        $totalMandiriMobil += $result->Mandiri_Mobil;
                        $totalMandiriMotor += $result->Mandiri_Motor;
                        $totalBCAMobil += $result->BCA_Mobil;
                        $totalBCAMotor += $result->BCA_Motor;
                        $totalBNIMobil += $result->BNI_Mobil;
                        $totalBNIMotor += $result->BNI_Motor;
                        $totalBRIMobil += $result->BRI_Mobil;
                        $totalBRIMotor += $result->BRI_Motor;
                    ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="10"><strong>Total</strong></td>
                <td><strong><?php echo e(number_format($total)); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Metode Pembayaran</th>
                <th>Motor</th>
                <th>Mobil</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mandiri</td>
                <td><?php echo e(number_format($totalMandiriMotor)); ?></td>
                <td><?php echo e(number_format($totalMandiriMobil)); ?></td>
                <td><?php echo e(number_format($totalMandiriMobil + $totalMandiriMotor)); ?></td>
            </tr>
            <tr>
                <td>BCA</td>
                <td><?php echo e(number_format($totalBCAMotor)); ?></td>
                <td><?php echo e(number_format($totalBCAMobil)); ?></td>
                <td><?php echo e(number_format($totalBCAMobil + $totalBCAMotor)); ?></td>
            </tr>
            <tr>
                <td>BNI</td>
                <td><?php echo e(number_format($totalBNIMotor)); ?></td>
                <td><?php echo e(number_format($totalBNIMobil)); ?></td>
                <td><?php echo e(number_format($totalBNIMobil + $totalBNIMotor)); ?></td>
            </tr>
            <tr>
                <td>BRI</td>
                <td><?php echo e(number_format($totalBRIMotor)); ?></td>
                <td><?php echo e(number_format($totalBRIMobil)); ?></td>
                <td><?php echo e(number_format($totalBRIMobil + $totalBRIMotor)); ?></td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><?php echo e(number_format($totalBRIMotor + $totalBCAMotor + $totalBNIMotor + $totalMandiriMotor)); ?></strong></td>
                <td><strong><?php echo e(number_format($totalBRIMobil + $totalBCAMobil + $totalBNIMobil + $totalMandiriMobil)); ?></strong></td>
                <td><strong><?php echo e(number_format($total)); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <h3>Data Transaksi per Jenis Kendaraan</h3>
    <table>
        <thead>
            <tr style="height: 16.0pt;">
                <th>No</th>
                <th>Tanggal</th>
                <th>Motor</th>
                <th>Mobil</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalharianmotor = 0;
                $totalharianmobil = 0;
            ?> 
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->date); ?></td>
                    <td align="right"><?php echo e(number_format($result->Mandiri_Motor + $result->BCA_Motor + $result->BNI_Motor + $result->BRI_Motor)); ?></td>
                    <td align="right"><?php echo e(number_format($result->Mandiri_Mobil + $result->BCA_Mobil + $result->BNI_Mobil + $result->BRI_Mobil)); ?></td>
                    <td align="right"><?php echo e(number_format($result->total)); ?></td>
                    <?php
                        $totalharianmotor += $result->Mandiri_Motor + $result->BCA_Motor + $result->BNI_Motor + $result->BRI_Motor;
                        $totalharianmobil += $result->Mandiri_Mobil + $result->BCA_Mobil + $result->BNI_Mobil + $result->BRI_Mobil;
                    ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td><strong><?php echo e(number_format($total)); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <h4>Summary</h4>
    <table>
        <thead>
            <tr>
                <th>Jenis Kendaraan</th>
                <th>Lalin</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Motor</td>
                <td><?php echo e(number_format($totalharianmotor)); ?></td>
            </tr>
            <tr>
                <td>Mobil</td>
                <td><?php echo e(number_format($totalharianmobil)); ?></td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><?php echo e(number_format($totalharianmotor + $totalharianmobil)); ?></strong></td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="landscape">
        <h3>Data Transaksi Per Jam</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>1 jam</th>
                    <th>1 - 2 jam</th>
                    <th>2 - 3 jam</th>
                    <th>3 - 2 jam</th>
                    <th>4 - 3 jam</th>
                    <th>5 - 2 jam</th>
                    <th>6 - 3 jam</th>
                    <th>7 - 2 jam</th>
                    <th>8 - 3 jam</th>
                    <th>9 - 2 jam</th>
                    <th>10 - 3 jam</th>
                    <th>11 - 2 jam</th>
                    <th>> 12 jam</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $datahours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr role="row">
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($hours->tanggal); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s0sampai1)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s1sampai2)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s2sampai3)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s3sampai4)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s4sampai5)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s5sampai6)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s6sampai7)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s7sampai8)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s8sampai9)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s9sampai10)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s10sampai11)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->s11sampai12)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->diatas12)); ?></td>
                        <td align="right"><?php echo e(number_format($hours->total)); ?> transaksi</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        Tanggal Cetak: <?php echo e(date('d F Y')); ?>

    </div>
</body>
</html><?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/PDF/pdfqty.blade.php ENDPATH**/ ?>