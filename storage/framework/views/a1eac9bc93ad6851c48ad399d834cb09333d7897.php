<?php echo e(Form::model($rfidVehicle, ['route' => ['rfid-vehicle.update', $rfidVehicle->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name', __('Nama'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nama')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('phone_number', __('Nomor HP'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('phone_number', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nomor HP')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('vehicleid', __('Jenis Kendaraan'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('vehicleid', [
            '1' => 'Mobil',
            '2' => 'Motor'
            ], $rfidVehicle->vehicleid, ['class' => 'form-control hidesearch', 'id' => 'vehicleid', 'placeholder' => __('Pilih Jenis Kendaraan'), 'disabled' => 'disabled'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('company_name', __('Nama Perusahaan'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('company_name', null, ['class' => 'form-control', 'placeholder' => __('Pilih Nama Perusahaan')])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('membertype', __('Produk'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('product_code', $rfidVehicle->member_type, [
            'class' => 'form-control',
            'id' => 'product_code',
            'readonly' => 'readonly'
            ])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('vehicle_no', __('Nomor Polisi'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('vehicle_no', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nomor Polisi')])); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('rfid_no', __('Nomor RFID'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('rfid_no', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nomor RFID')])); ?>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('start_date', null, ['class' => 'form-control', 'disabled' => 'disabled'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('end_date', null, ['class' => 'form-control', 'disabled' => 'disabled'])); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('notes', __('Notes'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => __('Enter notes'), 'rows' => 2])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-primary btn-rounded'])); ?>

</div>
<?php echo e(Form::close()); ?>


<script>
$(document).ready(function () {
    var member_type = "<?php echo e($rfidVehicle->member_type); ?>"; // Ambil nilai dari Blade
    
    if (member_type) {
        var url = '<?php echo e(route("membertype", ":member_type")); ?>';
        url = url.replace(':member_type', member_type);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                if (data.length > 0) {
                    $('#product_code').val(data[0].keterangan); // Set nilai input dengan keterangan
                }
            },
            error: function () {
                alert("Gagal mengambil data produk.");
            }
        });
    }
});

    // Mencegah enter di field RFID
    $('#rfid_no').on('keydown', function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });

</script>

<?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/rfid_vehicle/edit.blade.php ENDPATH**/ ?>