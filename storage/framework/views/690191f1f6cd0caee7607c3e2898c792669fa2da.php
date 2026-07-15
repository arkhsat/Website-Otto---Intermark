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
                <th colspan="13">
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
                <th class="xl66" rowspan="2" >No</th>
                <th class="xl66" rowspan="2" >Tanggal</th>
                <th class="xl65" colspan="2" >RFID</th>
                <th class="xl65" colspan="1" >Blue Bird</th>
                <th class="xl65" rowspan="2" >TOTAL</th>
            </tr>
            <tr>
                <th>Mobil</th>
                <th>Motor</th>
                <th>Mobil</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $totalMobil = 0;
                $totalMotor = 0;
            ?>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($result->date); ?></td>
                    <td><?php echo e(number_format($result->RFID_Mobil)); ?></td>
                    <td><?php echo e(number_format($result->RFID_Motor)); ?></td>
                    <td><?php echo e(number_format($result->BLUEBIRD_Mobil)); ?></td>
                    <td><?php echo e(number_format($result->total)); ?></td>
                    <?php
                        $total += $result->total;
                        $totalMobil += $result->RFID_Mobil + $result->BLUEBIRD_Mobil;
                        $totalMotor += $result->RFID_Motor;
                    ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="5"><strong>Total</strong></td>
                <td><strong><?php echo e(number_format($total)); ?></strong></td>
            </tr>
        </tbody>
        <tr></tr>
        <tr>
            <td></td>
            <td><strong>Total Mobil</strong></td>
            <td><strong><?php echo e(number_format($totalMobil)); ?></strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Total Motor</strong></td>
            <td><strong><?php echo e(number_format($totalMotor)); ?></strong></td>
        </tr>
    </table>
</body>
</html><?php /**PATH D:\laragon\www\Intermark\resources\views/exports/reportexcelmemberqty.blade.php ENDPATH**/ ?>