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
                <th colspan="11">
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
                <th class="xl66" rowspan="2" >No</th>
                <th class="xl66" rowspan="2" >Tanggal</th>
                <th class="xl65" colspan="2" >Mandiri</th>
                <th class="xl65" colspan="2" >BCA</th>
                <th class="xl65" colspan="2" >BNI</th>
                <th class="xl65" colspan="2" >BRI</th>
                <th class="xl65" rowspan="2" >TOTAL</th>
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
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->date); ?></td>
                    <td><?php echo e(number_format($result->Mandiri_Mobil)); ?></td>
                    <td><?php echo e(number_format($result->Mandiri_Motor)); ?></td>
                    <td><?php echo e(number_format($result->BCA_Mobil)); ?></td>
                    <td><?php echo e(number_format($result->BCA_Motor)); ?></td>
                    <td><?php echo e(number_format($result->BNI_Mobil)); ?></td>
                    <td><?php echo e(number_format($result->BNI_Motor)); ?></td>
                    <td><?php echo e(number_format($result->BRI_Mobil)); ?></td>
                    <td><?php echo e(number_format($result->BRI_Motor)); ?></td>
                    <td><?php echo e(number_format($result->total)); ?></td>
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
</body>
</html><?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/exports/reportexcelqty.blade.php ENDPATH**/ ?>