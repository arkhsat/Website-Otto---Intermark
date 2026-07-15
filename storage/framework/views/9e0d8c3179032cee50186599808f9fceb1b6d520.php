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
                <th colspan="4">
                    <div class="header">
                        <div class="title">
                            <h2><?php echo e($judul); ?></h2>
                            <h4><?php echo e(config('app.location')); ?></h4>
                            <p>Tanggal : <?php echo e(date('d F Y', strtotime($Date))); ?>


                            </p>
                        </div>
                    </div>
                </th>
            </tr>
            
            <tr>
                <th>Metode Pembayaran</th>
                <th>Jenis Kendaraan</th>
                <th>Lalin</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $result = $data[0];
            ?>
            <tr>
                <td rowspan="2">Mandiri</td>
                <td>Mobil</td>
                <td align="right"><?php echo e(number_format($result->Lalin_Mandiri_Mobil)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_Mandiri_Mobil)); ?></td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right"><?php echo e(number_format($result->Lalin_Mandiri_Motor)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_Mandiri_Motor)); ?></td>
            </tr>
            <tr>
                <td rowspan="2">BCA</td>
                <td>Mobil</td>
                <td align="right"><?php echo e(number_format($result->Lalin_BCA_Mobil)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_BCA_Mobil)); ?></td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right"><?php echo e(number_format($result->Lalin_BCA_Motor)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_BCA_Motor)); ?></td>
            </tr>
            <tr>
                <td rowspan="2">BNI</td>
                <td>Mobil</td>
                <td align="right"><?php echo e(number_format($result->Lalin_BNI_Mobil)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_BNI_Mobil)); ?></td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right"><?php echo e(number_format($result->Lalin_BNI_Motor)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_BNI_Motor)); ?></td>
            </tr>
            <tr>
                <td rowspan="2">BRI</td>
                <td>Mobil</td>
                <td align="right"><?php echo e(number_format($result->Lalin_BRI_Mobil)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_BRI_Mobil)); ?></td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right"><?php echo e(number_format($result->Lalin_BRI_Motor)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_BRI_Motor)); ?></td>
            </tr>
            <tr>
                <td rowspan="2">Member</td>
                <td>Mobil</td>
                <td align="right"><?php echo e(number_format($result->Lalin_Member_Mobil)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_Member_Mobil)); ?></td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right"><?php echo e(number_format($result->Lalin_Member_Motor)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_Member_Motor)); ?></td>
            </tr>
            <tr>
                <td rowspan="2">Hotel</td>
                <td>Mobil</td>
                <td align="right"><?php echo e(number_format($result->Lalin_Hotel_Mobil)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_Hotel_Mobil)); ?></td>
            </tr>
            <tr>
                <td>Motor</td>
                <td align="right"><?php echo e(number_format($result->Lalin_Hotel_Motor)); ?></td>
                <td align="right"><?php echo e(number_format($result->Amount_Hotel_Motor)); ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong><?php echo e(number_format($result->Lalin_Mandiri_Mobil + $result->Lalin_Mandiri_Motor +
                    $result->Lalin_BCA_Mobil + $result->Lalin_BCA_Motor +
                    $result->Lalin_BNI_Mobil + $result->Lalin_BNI_Motor +
                    $result->Lalin_BRI_Mobil + $result->Lalin_BRI_Motor +
                    $result->Lalin_Member_Mobil + $result->Lalin_Member_Motor +
                    $result->Lalin_Hotel_Mobil + $result->Lalin_Hotel_Motor)); ?></strong></td>
                <td><strong><?php echo e(number_format($result->Amount_Mandiri_Mobil + $result->Amount_Mandiri_Motor +
                    $result->Amount_BCA_Mobil + $result->Amount_BCA_Motor +
                    $result->Amount_BNI_Mobil + $result->Amount_BNI_Motor +
                    $result->Amount_BRI_Mobil + $result->Amount_BRI_Motor +
                    $result->Amount_Member_Mobil + $result->Amount_Member_Motor +
                    $result->Amount_Hotel_Mobil + $result->Amount_Hotel_Motor)); ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html><?php /**PATH E:\web-admin-dev\resources\views/exports/reportexceldaily.blade.php ENDPATH**/ ?>