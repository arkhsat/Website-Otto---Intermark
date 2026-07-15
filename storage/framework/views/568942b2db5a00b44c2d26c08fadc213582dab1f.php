

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('RFID Vehicle Blue Bird')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('dashboard')); ?>">
                <h1><?php echo e(__('Dashboard')); ?></h1>
            </a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#"><?php echo e(__('RFID Blue Bird')); ?></a>
        </li>
    </ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('card-action-btn'); ?>
        <a class="btn btn-primary btn-sm ml-20 customModal" href="#" data-size="lg"
           data-url="<?php echo e(route('rfid-vehicle-bluebird.create')); ?>"
           data-title="<?php echo e(__('Create RFID Blue Bird')); ?>">
            <i class="ti-plus mr-5"></i><?php echo e(__('Create UID Blue Bird')); ?>

        </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- <button id="btnPrint" class="btn btn-info mb-3">Cetak Laporan</button> -->
                    <!-- <button id="btnExcel" class="btn btn-success mb-3">Download Excel</button> -->
                    <div class="table-responsive">
                        <table class="display dataTable cell-border datatbl-advance" id="rfidVehicleTable">
                            <thead>
                            <tr>
                                <th>UID NO</th>
                                    <th class="text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <a class="text-success customModal" data-bs-toggle="tooltip"
                                           data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                           data-url="<?php echo e(route('rfid-vehicle-bluebird.edit', $vehicle->id)); ?>"
                                           data-title="<?php echo e(__('Edit RFID Blue Bird')); ?>">
                                            <?php echo e($vehicle->uidno); ?>

                                        </a>
                                    </td>
                                        <td class="text-right">
                                            <div class="cart-action">
                                                <a class="btn btn-primary customModal" data-bs-toggle="tooltip"
                                                   data-bs-original-title="<?php echo e(__('Edit')); ?>" data-size="lg" href="#"
                                                   data-url="<?php echo e(route('rfid-vehicle-bluebird.edit', $vehicle->id)); ?>"
                                                   data-title="<?php echo e(__('Edit RFID Blue Bird')); ?>">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
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

document.addEventListener("DOMContentLoaded", function () {
    const btnExcel = document.getElementById("btnExcel");

    if (btnExcel) {
        btnExcel.addEventListener("click", function () {
            let table = $('#rfidVehicleTable').DataTable();
            let filteredData = table.rows({ search: 'applied' }).nodes();

            let ths = $('#rfidVehicleTable thead tr th').slice(1, 8);
            let csvContent = '';
            
            // Header
            ths.each(function () {
                csvContent += '"' + $(this).text().trim() + '",';
            });
            csvContent = csvContent.slice(0, -1); // hapus koma terakhir
            csvContent += "\n";

            // Data
            for (let i = 0; i < filteredData.length; i++) {
                let row = '';
                let cells = $(filteredData[i]).find('td').slice(1, 8);
                cells.each(function () {
                    row += '"' + $(this).text().trim() + '",';
                });
                row = row.slice(0, -1);
                csvContent += row + "\n";
            }

            // Download
            let blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            let link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "rfid_vehicle.xlsx"; // bisa pakai .csv juga
            link.click();
        });
    }
});

</script>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\WEB Baru\web-admin-dev\resources\views/rfid_bluebird/index.blade.php ENDPATH**/ ?>