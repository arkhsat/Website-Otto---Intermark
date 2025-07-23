<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('RFID Vehicle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>">
                <h1><?php echo e(__('Dashboard')); ?></h1>
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('RFID Vehicle')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
    <?php if(Gate::check('create rfid vehicle')): ?>
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="<?php echo e(route('rfid-vehicle.create')); ?>"
           data-title="<?php echo e(__('Create RFID Vehicle')); ?>">
            <i class="ti-plus mr-5"></i><?php echo e(__('Create RFID Vehicle')); ?>

        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button id="btnPrint" class="btn btn-info mb-3">Cetak Laporan</button>
                    <div class="table-responsive">
                        <table class="display dataTable cell-border datatbl-advance" id="rfidVehicleTable">
                            <thead>
                            <tr>
                                <th>RFID</th>
                                <th>Plat Nomor</th>
                                <th>Kendaraan</th>
                                <th>Nama</th>
                                <th>Company</th>
                                <th>Awal Berlaku</th>
                                <th>Kadaluarsa</th>
                                <th>Status</th>
                                <th>Produk</th>
                                <?php if(Gate::check('edit rfid vehicle') || Gate::check('delete rfid vehicle')): ?>
                                    <th class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a class="text-success customModal" data-bs-toggle="tooltip"
                                           data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                           data-url="<?php echo e(route('rfid-vehicle.edit', $vehicle->id)); ?>"
                                           data-title="<?php echo e(__('Edit RFID Vehicle')); ?>">
                                            <?php echo e($vehicle->rfid_no); ?>

                                        </a>
                                    </td>
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
                                    <td><?php echo e($vehicle->name); ?></td>
                                    <td><?php echo e($vehicle->company_name); ?></td>
                                    <td><?php echo e($vehicle->start_date); ?></td>
                                    <td><?php echo e($vehicle->end_date); ?></td>
                                    <td>
                                        <?php if(\Carbon\Carbon::parse($vehicle->end_date)->isPast() && \Carbon\Carbon::parse($vehicle->end_date)->lt(\Carbon\Carbon::today())): ?>
                                            <span class="badge badge-danger"><?php echo e(__('Kadaluarsa')); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-success"><?php echo e(__('Aktif')); ?></span>
                                        <?php endif; ?>

                                        <?php if(Str::startsWith($vehicle->rfid_no, 'B')): ?>
                                            <br><span class="badge badge-secondary"><?php echo e(__('Terblokir')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($vehicle->member_type_keterangan); ?></td>
                                    <?php if(Gate::check('edit rfid vehicle') || Gate::check('delete rfid vehicle')): ?>
                                        <td class="text-right">
                                            <div class="cart-action">
                                                <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                                   data-url="<?php echo e(route('rfid-vehicle.edit', $vehicle->id)); ?>"
                                                   data-title="<?php echo e(__('Edit RFID Vehicle')); ?>">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("btnPrint");
    if (btn) {
        btn.addEventListener("click", function () {
            let table = $('#rfidVehicleTable').DataTable();
            let filteredData = table.rows({ search: 'applied' }).nodes();

            let printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>ottoparking</title>');
            printWindow.document.write(`
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 14px; }
                    th { background-color: #f2f2f2; }
                    h2,h3 { text-align: center; }
                </style>
            `);
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>Data Member</h2>');
            printWindow.document.write('<h3>Otto Parking - Intermark Indonesia</h3>');

            let ths = $('#rfidVehicleTable thead tr th').slice(1, 8);
            let htmlTable = '<table><thead><tr>';
            ths.each(function () {
                htmlTable += '<th>' + $(this).text() + '</th>';
            });
            htmlTable += '</tr></thead><tbody>';

            for (let i = 0; i < filteredData.length; i++) {
                let cells = $(filteredData[i]).find('td').slice(1, 8);
                htmlTable += '<tr>';
                cells.each(function () {
                    htmlTable += '<td>' + $(this).text() + '</td>';
                });
                htmlTable += '</tr>';
            }

            htmlTable += '</tbody></table>';

            printWindow.document.write(htmlTable);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\website-otto\resources\views/rfid_vehicle/index.blade.php ENDPATH**/ ?>