<?php echo e(Form::model($vehicle, array('route' => array('rfid-extend.update', $vehicle->id), 'method' => 'PUT'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('name', __('Nama'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('name', null, array('class' => 'form-control', 'disabled' => 'disabled'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('phone_number', __('Nomor HP'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('phone_number', null, array('class' => 'form-control', 'disabled' => 'disabled'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('vehicle_type', __('Jenis Kendaraan'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::select('vehicle_type', $vehicleTypes->toArray(), $vehicle->vehicleid, array('class' => 'form-control hidesearch', 'id' => 'vehicle_type'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('company_name', __('Nama Perusahaan'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('company_name', null, array('class' => 'form-control', 'disabled' => 'disabled'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('membertype', __('Produk'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::select('membertype', [], null, array('class' => 'form-control hidesearch', 'id' => 'product_code'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('vehicle_no', __('Nomor Polisi'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('vehicle_no', null, array('class' => 'form-control', 'disabled' => 'disabled'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('price', __('Harga'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('price', null, array('class' => 'form-control', 'id' => 'price', 'disabled' => 'disabled'))); ?>

            <?php echo e(Form::hidden('price', null, array('id' => 'hidden_price'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('rfid_no', __('Nomor RFID'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('rfid_no', null, array('class' => 'form-control', 'disabled' => 'disabled'))); ?>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('start_date', __('Start Date'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::date('start_date', null, array('class' => 'form-control'))); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('end_date', __('End Date'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::date('end_date', null, array('class' => 'form-control'))); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('notes', __('Notes'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::textarea('notes', null, array('class' => 'form-control', 'placeholder' => __('Enter notes'), 'rows' => 2))); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Update'), array('class' => 'btn btn-primary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>


<script>
    $(document).ready(function () {
        var vehicle_id = $('#vehicle_type').val(); // Ambil nilai vehicle_id saat pertama kali modal terbuka
        var productPrices = {}; // Object to store product prices
        var productMonth = {};
    
        if (vehicle_id) {
            loadProductOptions(vehicle_id); // Panggil fungsi untuk mengambil data produk berdasarkan vehicle_id
        }
    
        // Fungsi untuk mengambil data produk berdasarkan vehicle_id
        function loadProductOptions(vehicle_id) {
            var url = '<?php echo e(route("vehicleid", ":vehicle_id")); ?>';
            url = url.replace(':vehicle_id', vehicle_id);
    
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                success: function (data) {
                    $('#product_code').empty();
                    $('#product_code').append('<option value=""><?php echo e(__("Pilih Produk")); ?></option>');
    
                    $.each(data, function (index, item) {
                        $('#product_code').append('<option value="' + item.product_code + '">' + item.keterangan + '</option>');
                        productPrices[item.product_code] = item.price; // Store product price
                        productMonth[item.product_code] = item.month; // Store product month
                    });
                },
                error: function () {
                    alert("Terjadi kesalahan saat mengambil data produk.");
                }
            });
        }
    
        // Ketika vehicle_type berubah, muat ulang daftar produk
        $('#vehicle_type').on('change', function () {
            var selectedVehicleId = $(this).val();
            if (selectedVehicleId) {
                loadProductOptions(selectedVehicleId);
            } else {
                $('#product_code').empty();
                $('#product_code').append('<option value=""><?php echo e(__("Pilih Produk")); ?></option>');
            }
        });

        // Fungsi untuk menghitung tanggal akhir berdasarkan logika yang diberikan
        function calculateEndDate(month) {
            var today = new Date();
            var endDate = new Date();

            if (month === 0) {
                return endDate.toISOString().split('T')[0]; // Return today's date if month is 0
            }

            if (today.getDate() >= 25 && today.getDate() <= 31) {
                endDate.setMonth(today.getMonth() + month + 1);
                endDate.setDate(5);
            } else if (today.getDate() >= 1) {
                endDate.setMonth(today.getMonth() + month);
                endDate.setDate(5);
            }

            return endDate.toISOString().split('T')[0];
        }

        // Fungsi untuk memformat angka dengan pemisah ribuan
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        // Ketika product_code berubah, muat ulang harga
        $('#product_code').on('change', function () {
            var selectedProductCode = $(this).val();
            if (selectedProductCode && productPrices[selectedProductCode] !== undefined) {
                var price = productPrices[selectedProductCode];
                $('#price').val(formatRupiah(price.toString(), 'Rp '));
                $('#hidden_price').val(price); // Set hidden input value
                var month = productMonth[selectedProductCode];
                $('#end_date').val(calculateEndDate(month));
            } else {
                $('#price').val('');
                $('#hidden_price').val(''); // Clear hidden input value
                $('#end_date').val('');
            }
        });
    
        // Mencegah enter di field RFID
        $('#rfid_no').on('keydown', function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    });
</script><?php /**PATH E:\Kerja\parkingsystem\parkingsystem\resources\views/rfid_extend/edit.blade.php ENDPATH**/ ?>