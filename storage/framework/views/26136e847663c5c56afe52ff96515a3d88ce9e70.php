<?php echo e(Form::model($rfidVehicle, ['route' => ['rfid-vehicle.update', $rfidVehicle->id], 'method' => 'PUT'])); ?>

<?php
    use Illuminate\Support\Str;
?>

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
            ], $rfidVehicle->vehicleid, ['class' => 'form-control hidesearch', 'id' => 'vehicleid', 'placeholder' => __('Pilih Jenis Kendaraan'), 'readonly' => 'readonly'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('company_name', __('Nama Perusahaan'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::select('company_name', ['' => __('Pilih Perusahaan')] + $company->toArray(), null, array('class' => 'form-control hidesearch'))); ?>

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
            <label class="form-label"><?php echo e(__('Status Kartu')); ?></label>
            <div>
                <label>
                    <input type="radio" name="card_status" value="lost" id="card_lost"> <?php echo e(__('Kartu Hilang')); ?>

                </label>
                <label style="margin-left: 15px;">
                    <input type="radio" name="card_status" value="damaged" id="card_damaged"> <?php echo e(__('Kartu Rusak')); ?>

                </label>
                
                <?php if(!Str::startsWith($rfidVehicle->rfid_no, 'B')): ?>
                    <label style="margin-left: 15px;">
                        <input type="radio" name="card_status" value="blokir" id="card_blokir"> <?php echo e(__('Blokir Kartu')); ?>

                    </label>
                <?php endif; ?>
                
                <?php if($rfidVehicle->rfid_no == null || $rfidVehicle->rfid_no == '' || Str::startsWith($rfidVehicle->rfid_no, 'B')): ?>
                    <label style="margin-left: 15px;">
                        <input type="radio" name="card_status" value="activate" id="card_activate"> <?php echo e(__('Aktifkan Kembali')); ?>

                    </label>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="form-group col-md-12">
            <?php echo e(Form::label('rfid_no', __('Nomor RFID'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::text('rfid_no', null, ['class' => 'form-control', 'placeholder' => __('Masukkan Nomor RFID'), 'id' => 'rfid_no', 'disabled' => 'disabled'])); ?>

            <?php echo e(Form::hidden('rfid_no', null, ['id' => 'rfid_no_hidden'])); ?>

        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('start_date', date('Y-m-d', strtotime($rfidVehicle->start_date)), ['class' => 'form-control', 'readonly' => 'readonly'])); ?>

            <?php echo e(Form::hidden('start_date', date('Y-m-d', strtotime($rfidVehicle->start_date)))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::date('end_date', date('Y-m-d', strtotime($rfidVehicle->end_date)), ['class' => 'form-control', 'readonly' => 'readonly'])); ?>

            <?php echo e(Form::hidden('end_date', date('Y-m-d', strtotime($rfidVehicle->end_date)))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('notes', __('Notes'), ['class' => 'form-label'])); ?>

            <?php echo e(Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => __('Enter notes'), 'rows' => 2])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Update'), ['class' => 'btn btn-primary btn-rounded', 'id' => 'submitBtn'])); ?>

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

    $('input[name="card_status"]').on('change', function () {
    var rfid_Number = $('#rfid_no').val();

    if ($('#card_lost').is(':checked') || $('#card_damaged').is(':checked')) {
        $('#rfid_no').prop('disabled', false);
        console.log('Enable RFID input');
    } else if ($('#card_blokir').is(':checked')) {
        $('#rfid_no').prop('disabled', false);
        console.log('Blokir Kartu');
        console.log('B'+rfid_Number); 
        $('#rfid_no').val('B'+rfid_Number);
        $('#rfid_no_hidden').val('B'+rfid_Number);
        $('#notes').val('RFID Sebelum Di Blokir : '+rfid_Number);
    } else if ($('#card_activate').is(':checked')) {
        if (rfid_Number.startsWith('B')) {
            $('#rfid_no').prop('disabled', false);
            $('#rfid_no').val(rfid_Number.substring(1));
            $('#rfid_no_hidden').val(rfid_Number.substring(1));
        } else {
            $('#rfid_no').prop('disabled', false);
            $('#rfid_no').val(rfid_Number);
            $('#rfid_no_hidden').val(rfid_Number);
        }
        $('#notes').val('Diaktifkan Kembali');
    } else {
        $('#rfid_no').prop('disabled', true).val('');
        $('#rfid_no_hidden').val('');
    }
});

// Sync value ke hidden saat input berubah
$('#rfid_no').on('input', function () {
    $('#rfid_no_hidden').val($(this).val());
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Processing...'; // opsional untuk UX
    });
});
    

</script>

<?php /**PATH E:\website-otto\resources\views/rfid_vehicle/edit.blade.php ENDPATH**/ ?>