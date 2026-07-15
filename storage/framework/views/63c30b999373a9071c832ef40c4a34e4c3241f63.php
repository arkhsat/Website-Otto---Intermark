<!-- filepath: e:\Kerja\parkingsystem\parkingsystem\resources\views\rfid_vehicle\create.blade.php -->

<?php echo e(Form::open(array('url' => 'rfid-vehicle-bluebird', 'method' => 'post'))); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('uidno', __('UID No'), array('class' => 'form-label'))); ?>

            <?php echo e(Form::text('uidno', null, array('class' => 'form-control', 'placeholder' => __('Masukkan UID No')))); ?>

        </div>
    </div>
   
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <?php echo e(Form::submit(__('Create'), array('class' => 'btn btn-primary btn-rounded'))); ?>

</div>
<?php echo e(Form::close()); ?>


<script>
    $(document).ready(function () {
        var vehicle_id = $('#vehicle_type').val(); // Ambil nilai vehicle_id saat pertama kali modal terbuka
        var productPrices = {}; // Object to store product prices
        var productMonth = {};
        var newcard = {};
    
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
                        productPrices[item.product_code] = item.price + item.newcard; // Store product price
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

            endDate.setDate(1); // ✅ Set tanggal ke 1 dulu supaya aman dari lompat bulan

            if (today.getDate() >= 25 && today.getDate() <= 31) {
                endDate.setMonth(today.getMonth() + 1 + month);
            } else {
                endDate.setMonth(today.getMonth() + month);
            }

            endDate.setDate(5); // ✅ Baru atur tanggal akhir

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
</script><?php /**PATH E:\WEB Baru\web-admin-dev\resources\views/rfid_bluebird/create.blade.php ENDPATH**/ ?>