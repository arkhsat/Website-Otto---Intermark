<!-- filepath: e:\Kerja\parkingsystem\parkingsystem\resources\views\rfid_vehicle\create.blade.php -->

{{ Form::open(array('url' => 'rfid-vehicle', 'method' => 'post')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('name', __('Nama'), array('class' => 'form-label')) }}
            {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => __('Masukkan Nama'))) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('phone_number', __('Nomor HP'), array('class' => 'form-label')) }}
            {{ Form::text('phone_number', null, array('class' => 'form-control', 'placeholder' => __('Masukkan Nomor HP'))) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('vehicle_type', __('Jenis Kendaraan'), array('class' => 'form-label')) }}
            {{ Form::select('vehicle_type', ['' => __('Pilih Jenis Kendaraan')] + $vehicleTypes->toArray(), null, array('class' => 'form-control hidesearch', 'id' => 'vehicle_type')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('company_name', __('Nama Perusahaan'), array('class' => 'form-label')) }}
            {{-- {{ Form::text('company_name', null, array('class' => 'form-control', 'placeholder' => __('Pilih Nama Perusahaan'))) }} --}}
            {{ Form::select('company_name', ['' => __('Pilih Perusahaan')] + $company->toArray(), null, array('class' => 'form-control hidesearch')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('membertype', __('Produk'), array('class' => 'form-label')) }}
            {{ Form::select('membertype', [], null, array('class' => 'form-control hidesearch', 'id' => 'product_code', 'placeholder' => 'Pilih Produk')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('vehicle_no', __('Nomor Polisi'), array('class' => 'form-label')) }}
            {{ Form::text('vehicle_no', null, array('class' => 'form-control', 'placeholder' => __('Masukkan Nomor Polisi'))) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('price', __('Harga'), array('class' => 'form-label')) }}
            {{ Form::text('price', null, array('class' => 'form-control', 'id' => 'price', 'disabled' => 'disabled')) }}
            {{ Form::hidden('price', null, array('id' => 'hidden_price')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('rfid_no', __('Nomor RFID'), array('class' => 'form-label')) }}
            {{ Form::text('rfid_no', null, array('class' => 'form-control', 'placeholder' => __('Masukkan Nomor RFID'))) }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            {{ Form::label('start_date', __('Start Date'), array('class' => 'form-label')) }}
            {{ Form::date('start_date', date('Y-m-d'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('end_date', __('End Date'), array('class' => 'form-label')) }}
            {{ Form::date('end_date', date('Y-m-d'), array('class' => 'form-control')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('notes', __('Notes'), array('class' => 'form-label')) }}
            {{ Form::textarea('notes', null, array('class' => 'form-control', 'placeholder' => __('Enter notes'), 'rows' => 2)) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Create'), array('class' => 'btn btn-primary btn-rounded')) }}
</div>
{{ Form::close() }}

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
            var url = '{{ route("vehicleid", ":vehicle_id") }}';
            url = url.replace(':vehicle_id', vehicle_id);
    
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                success: function (data) {
                    $('#product_code').empty();
                    $('#product_code').append('<option value="">{{ __("Pilih Produk") }}</option>');
    
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
                $('#product_code').append('<option value="">{{ __("Pilih Produk") }}</option>');
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
</script>