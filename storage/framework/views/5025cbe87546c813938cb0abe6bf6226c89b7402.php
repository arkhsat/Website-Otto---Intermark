<!-- filepath: /e:/Kerja/parkingsystem/parkingsystem/resources/views/exports/reportexcelqty2.blade.php -->

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
                <th colspan="26">
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
                <th>Tanggal</th>
                <th>0 &gt; x &lt; 1</th>
                <th>1 &gt; x &lt; 2</th>
                <th>2 &gt; x &lt; 3</th>
                <th>3 &gt; x &lt; 4</th>
                <th>4 &gt; x &lt; 5</th>
                <th>5 &gt; x &lt; 6</th>
                <th>6 &gt; x &lt; 7</th>
                <th>7 &gt; x &lt; 8</th>
                <th>8 &gt; x &lt; 9</th>
                <th>9 &gt; x &lt; 10</th>
                <th>10 &gt; x &lt; 11</th>
                <th>11 &gt; x &lt; 12</th>
                <th>12 &gt; x &lt; 13</th>
                <th>13 &gt; x &lt; 14</th>
                <th>14 &gt; x &lt; 15</th>
                <th>15 &gt; x &lt; 16</th>
                <th>16 &gt; x &lt; 17</th>
                <th>17 &gt; x &lt; 18</th>
                <th>18 &gt; x &lt; 19</th>
                <th>19 &gt; x &lt; 20</th>
                <th>20 &gt; x &lt; 21</th>
                <th>21 &gt; x &lt; 22</th>
                <th>22 &gt; x &lt; 23</th>
                <th>23 &gt; x &lt; 24</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total0sampai1 = 0;
                $total1sampai2 = 0;
                $total2sampai3 = 0;
                $total3sampai4 = 0;
                $total4sampai5 = 0;
                $total5sampai6 = 0;
                $total6sampai7 = 0;
                $total7sampai8 = 0;
                $total8sampai9 = 0;
                $total9sampai10 = 0;
                $total10sampai11 = 0;
                $total11sampai12 = 0;
                $total12sampai13 = 0;
                $total13sampai14 = 0;
                $total14sampai15 = 0;
                $total15sampai16 = 0;
                $total16sampai17 = 0;
                $total17sampai18 = 0;
                $total18sampai19 = 0;
                $total19sampai20 = 0;
                $total20sampai21 = 0;
                $total21sampai22 = 0;
                $total22sampai23 = 0;
                $total23sampai24 = 0;
                $totalTransaksi = 0;
            ?>
            <?php $__currentLoopData = $datahours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $hours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr role="row">
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($hours->tanggal); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam0)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam1)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam2)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam3)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam4)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam5)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam6)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam7)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam8)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam9)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam10)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam11)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam12)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam13)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam14)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam15)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam16)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam17)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam18)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam19)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam20)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam21)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam22)); ?></td>
                    <td align="right"><?php echo e(number_format($hours->jam23)); ?></td>
                </tr>
                <?php
                    $total0sampai1 += $hours->jam0;
                    $total1sampai2 += $hours->jam1;
                    $total2sampai3 += $hours->jam2;
                    $total3sampai4 += $hours->jam3;
                    $total4sampai5 += $hours->jam4;
                    $total5sampai6 += $hours->jam5;
                    $total6sampai7 += $hours->jam6;
                    $total7sampai8 += $hours->jam7;
                    $total8sampai9 += $hours->jam8;
                    $total9sampai10 += $hours->jam9;
                    $total10sampai11 += $hours->jam10;
                    $total11sampai12 += $hours->jam11;
                    $total12sampai13 += $hours->jam12;
                    $total13sampai14 += $hours->jam13;
                    $total14sampai15 += $hours->jam14;
                    $total15sampai16 += $hours->jam15;
                    $total16sampai17 += $hours->jam16;
                    $total17sampai18 += $hours->jam17;
                    $total18sampai19 += $hours->jam18;
                    $total19sampai20 += $hours->jam19;
                    $total20sampai21 += $hours->jam20;
                    $total21sampai22 += $hours->jam21;
                    $total22sampai23 += $hours->jam22;
                    $total23sampai24 += $hours->jam23;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td align="right"><strong><?php echo e(number_format($total0sampai1)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total1sampai2)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total2sampai3)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total3sampai4)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total4sampai5)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total5sampai6)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total6sampai7)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total7sampai8)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total8sampai9)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total9sampai10)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total10sampai11)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total11sampai12)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total12sampai13)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total13sampai14)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total14sampai15)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total15sampai16)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total16sampai17)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total17sampai18)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total18sampai19)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total19sampai20)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total20sampai21)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total21sampai22)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total22sampai23)); ?></strong></td>
                <td align="right"><strong><?php echo e(number_format($total23sampai24)); ?></strong></td> 
            </tr>
        </tbody>
    </table>
</body>
</html><?php /**PATH E:\Kerja\02. Intermark\Website Otto\resources\views/exports/reportexcelamount3.blade.php ENDPATH**/ ?>