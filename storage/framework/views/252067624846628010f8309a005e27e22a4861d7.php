
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Parking')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('Parking')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('card-action-btn'); ?>
    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th class="text-center"><?php echo e(__('Close Transaction')); ?></th>
                            <th class="text-center" style="width: 5%;"><?php echo e(__('ID')); ?></th>
                            <th class="text-center" style="width: 5%;"><?php echo e(__('Transaction No')); ?></th>
                            <th class="text-center"><?php echo e(__('Kendaraan')); ?></th>
                            <th class="text-center"><?php echo e(__('No Polisi')); ?></th>
                            <th class="text-center"><?php echo e(__('Masuk')); ?></th>
                            <th class="text-center"><?php echo e(__('Status')); ?></th>
                            <th class="text-center"><?php echo e(__('Gambar Kendaraan')); ?></th>                    
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $parkings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr role="row">

                                <td class="text-center">
                                    <form action="<?php echo e(route('parking.close', $parking->transactionid)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menutup transaksi ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            CLOSE
                                        </button>
                                    </form>
                                </td>
                                
                                <td> <?php echo e(parkingPrefix().$parking->transactionid); ?></td>
                                <td> <?php echo e($parking->tiketno); ?></td>
                                <td> <?php echo e($parking->vehicleid); ?>  </td>
                                <td> <?php echo e($parking->nopolisi); ?>  </td>
                                <td> <?php echo e($parking->datetransact); ?> </td>
                               
                                <td>
                                    <?php if($parking->alreadyout=='x'): ?>
                                        <span class="badge badge-danger">Keluar</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Di Area</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                <?php if($parking->posinid == '1'): ?>
                                    <a href="<?php echo e(asset('http://192.168.1.55/share/FotoPMLG/'.$parking->image_plate_in)); ?>" data-lightbox="parking-<?php echo e($parking->transactionid); ?>" data-title="Vehicle Image">
                                        <img src="<?php echo e(asset('http://192.168.1.55/share/FotoPMLG/'.$parking->image_plate_in)); ?>" 
                                            alt="Vehicle Image" 
                                            style="width: 200px; height: auto; cursor: pointer;"
                                            class="img-thumbnail">
                                    </a>
                                <?php elseif($parking->posinid == '2'): ?>
                                    <a href="<?php echo e(asset('http://192.168.1.55/share/FotoPMLoading/'.$parking->image_plate_in)); ?>" data-lightbox="parking-<?php echo e($parking->transactionid); ?>" data-title="Vehicle Image">
                                        <img src="<?php echo e(asset('http://192.168.1.55/share/FotoPMLoading/'.$parking->image_plate_in)); ?>" 
                                            alt="Vehicle Image" 
                                            style="width: 200px; height: auto; cursor: pointer;"
                                            class="img-thumbnail">
                                    </a>
                                <?php elseif($parking->posinid == '3'): ?>
                                    <a href="<?php echo e(asset('http://192.168.1.55/share/FotoPMMotor/'.$parking->image_plate_in)); ?>" data-lightbox="parking-<?php echo e($parking->transactionid); ?>" data-title="Vehicle Image">
                                        <img src="<?php echo e(asset('http://192.168.1.55/share/FotoPMMotor/'.$parking->image_plate_in)); ?>" 
                                            alt="Vehicle Image" 
                                            style="width: 200px; height: auto; cursor: pointer;"
                                            class="img-thumbnail">
                                    </a>
                                <?php else: ?>
                                    <span class="badge badge-danger">No Image</span>
                                <?php endif; ?>

                                </td>
                              
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\web-admin-dev\resources\views/parking/index.blade.php ENDPATH**/ ?>