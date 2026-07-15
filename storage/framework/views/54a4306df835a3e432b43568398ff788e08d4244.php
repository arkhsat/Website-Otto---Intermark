
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('RFID Vehicle')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>"><h1><?php echo e(__('Dashboard')); ?></h1></a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('RFID Vehicle')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="display dataTable cell-border datatbl-advance">
                        <thead>
                        <tr>
                            <th><?php echo e(__('RFID No')); ?></th>
                            <th><?php echo e(__('Plat Nomor')); ?></th>
                            <th><?php echo e(__('Kendaraan')); ?></th>
                            <th><?php echo e(__('Nama')); ?></th>
                            <th><?php echo e(__('Company')); ?></th>
                            <th><?php echo e(__('Awal Berlaku')); ?></th>
                            <th><?php echo e(__('Kadaluarsa')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <?php if(Gate::check('edit rfid vehicle') ||  Gate::check('delete rfid vehicle')): ?>
                                <th class="text-right"><?php echo e(__('Action')); ?></th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr role="row">
                                
                                <td><?php echo e($vehicle->rfid_no); ?></td>
                                <td><?php echo e($vehicle->vehicle_no); ?></td>
                                <td>                                     
                                    <?php if($vehicle->vehicleid == '1'): ?>
                                        Mobil
                                    <?php elseif($vehicle->vehicleid == '2'): ?>
                                        Motor
                                    <?php else: ?>
                                        Tidak Diketahui
                                    <?php endif; ?>  
                                </td>
                                <td><?php echo e($vehicle->name); ?> </td>
                                <td><?php echo e($vehicle->company_name); ?> </td>
                                <td><?php echo e($vehicle->start_date); ?> </td>
                                <td><?php echo e($vehicle->end_date); ?> </td>
                                <td>
                                    <?php if(\Carbon\Carbon::parse($vehicle->end_date)->isPast() && \Carbon\Carbon::parse($vehicle->end_date)->lt(\Carbon\Carbon::today())): ?>
                                        <span class="badge badge-danger"><?php echo e(__('Kadaluarsa')); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-success"><?php echo e(__('Aktif')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php if(Gate::check('edit rfid vehicle') ||  Gate::check('delete rfid vehicle')): ?>
                                <td class="text-right">
                                   
                                <div class="cart-action">
                                    
                                    <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                            data-url="<?php echo e(route('rfid-extend.extend',$vehicle->id)); ?>"
                                            data-title="<?php echo e(__('Perpanjang')); ?>">Perpanjang</a>
                                    
                                </div>
                                </td>
                                <?php endif; ?>
                               
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\Intermark\resources\views/rfid_extend/index.blade.php ENDPATH**/ ?>