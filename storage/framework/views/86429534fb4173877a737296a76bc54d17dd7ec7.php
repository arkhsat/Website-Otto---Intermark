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

        .header-row {
            height: 75px;
            text-align: center;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th colspan="27">
                <div class="header">
                    <div class="title">
                        <h2><?php echo e($judul); ?></h2>
                        <h4><?php echo e(config('app.location')); ?></h4>

                        <p>
                            Tanggal :
                            <?php if($startDate == $endDate): ?>
                                <?php echo e(date('d F Y', strtotime($startDate))); ?>

                            <?php else: ?>
                                <?php echo e(date('d F Y', strtotime($startDate))); ?>

                                s/d
                                <?php echo e(date('d F Y', strtotime($endDate))); ?>

                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </th>
        </tr>

        <tr>
            <th>No</th>
            <th>Tanggal</th>

            <?php for($i = 0; $i <= 23; $i++): ?>
                <th><?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>:00</th>
            <?php endfor; ?>

            <th>Total</th>
        </tr>
    </thead>

    <tbody>

        <?php
            $totals = [];

            for ($i = 0; $i <= 23; $i++) {
                $totals[$i] = 0;
            }

            $grandTotal = 0;
        ?>

        <?php $__currentLoopData = $datahours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <td><?php echo e($index + 1); ?></td>

                <td>
                    <?php echo e(date('d-m-Y', strtotime($hours->tanggal))); ?>

                </td>

                <?php for($i = 0; $i <= 23; $i++): ?>
                    <td align="right">
                        <?php echo e(number_format($hours->{'jam'.$i})); ?>

                    </td>
                <?php endfor; ?>

                <td align="right">
                    <?php echo e(number_format($hours->total)); ?>

                </td>
            </tr>

            <?php
                for ($i = 0; $i <= 23; $i++) {
                    $totals[$i] += $hours->{'jam'.$i};
                }

                $grandTotal += $hours->total;
            ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <tr>
            <td colspan="2">
                <strong>Total</strong>
            </td>

            <?php for($i = 0; $i <= 23; $i++): ?>
                <td align="right">
                    <strong><?php echo e(number_format($totals[$i])); ?></strong>
                </td>
            <?php endfor; ?>

            <td align="right">
                <strong><?php echo e(number_format($grandTotal)); ?></strong>
            </td>
        </tr>

    </tbody>
</table>

</body>
</html><?php /**PATH D:\laragon\www\Intermark\resources\views/exports/reportexcelposqty2.blade.php ENDPATH**/ ?>